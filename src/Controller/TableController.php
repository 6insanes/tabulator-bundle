<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Controller;

use DeviantLab\TabulatorBundle\FilterMode;
use DeviantLab\TabulatorBundle\OrmTableInterface;
use DeviantLab\TabulatorBundle\PaginationMode;
use DeviantLab\TabulatorBundle\SortMode;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

final class TableController
{
    public function __construct(
        private readonly ContainerInterface $locator,
        private readonly ManagerRegistry $doctrine,
        private readonly SerializerInterface $serializer,
    )
    {

    }

    public function __invoke(Request $request): Response
    {
        $tableName = $request->attributes->get('_tableName');
        /** @var OrmTableInterface $tableType */
        $tableType = $this->locator->get($tableName);

        $repo = $this->doctrine->getRepository($tableType->getEntityClass());
        $qb = $tableType->getQueryBuilder($repo);

        if ($tableType->getSortMode() === SortMode::REMOTE && $request->query->has('sort')) {
            $tableType->applySort($qb, $request->query->all('sort'));
        }

        if ($tableType->getFilterMode() === FilterMode::REMOTE && $request->query->has('filter')) {
            $tableType->applyFilter($qb, $request->query->all('filter'));
        }

        $pagination = $tableType->getPagination();
        if (!$pagination || $pagination->getMode() === PaginationMode::LOCAL) {
            $items = $qb->getQuery()->getResult();
            $items = $tableType->doTransform($items);
            $json = $this->serializer->serialize($items, 'json');
            return JsonResponse::fromJsonString($json);
        }

        $size = $request->query->getInt($pagination->getSizeParamName());
        $page = $request->query->getInt($pagination->getPageParamName());
        $tableType->applyPagination($qb, $size, $page);

        $paginator = new Paginator($qb);

        $items = iterator_to_array($paginator->getIterator());
        $items = $tableType->doTransform($items);

        $data = [
            'last_page' => ceil($paginator->count() / $size),
            'data' => $items,
        ];

        $json = $this->serializer->serialize($data, 'json');

        return JsonResponse::fromJsonString($json);
    }
}
