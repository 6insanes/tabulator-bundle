<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Controller;

use DeviantLab\TabulatorBundle\OrmTableInterface;
use DeviantLab\TabulatorBundle\Pagination;
use DeviantLab\TabulatorBundle\PaginationMode;
use DeviantLab\TabulatorBundle\SortMode;
use Doctrine\ORM\QueryBuilder;
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

        $pagination = $tableType->getPagination();
        if (!$pagination || $pagination->getMode() === PaginationMode::LOCAL) {
            $items = $qb->getQuery()->getResult();
            $items = $tableType->doTransform($items);
            $json = $this->serializer->serialize($items, 'json');
            return JsonResponse::fromJsonString($json);
        }

        if ($tableType->getSortMode() === SortMode::REMOTE) {
            $this->applySorting($qb, $request);
        }

        $size = $request->query->getInt($pagination->getSizeParamName());
        $page = $request->query->getInt($pagination->getPageParamName());

        $this->applyPagination($qb, $size, $page);
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

    private function applyPagination(QueryBuilder $qb, int $size, int $page): void
    {
        $qb->setMaxResults($size);
        $qb->setFirstResult(($page - 1) * $size);
    }

    private function applySorting(QueryBuilder $qb, Request $request): void
    {
        if (!$request->query->has('sort')) {
            return;
        }

        $sorts = $request->query->all('sort');
        foreach ($sorts as ['field' => $field, 'dir' => $dir]) {
            $fieldName = $qb->getRootAliases()[0].'.'.$field;
            $qb->addOrderBy($fieldName, $dir);
        }
    }
}
