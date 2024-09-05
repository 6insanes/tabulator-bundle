<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Server;

use DeviantLab\TabulatorBundle\TableInterface;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DeviantLab\TabulatorBundle\FilterMode;
use DeviantLab\TabulatorBundle\OrmTableInterface;
use DeviantLab\TabulatorBundle\PaginationMode;
use DeviantLab\TabulatorBundle\SortMode;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

final class OrmTableHandler implements TableHandlerInterface
{
    public function __construct(
        private readonly ManagerRegistry $doctrine,
        private readonly DoctrineHelper $doctrineHelper,
    )
    {

    }

    public function supports(TableInterface $tableType): bool
    {
        return $tableType instanceof OrmTableInterface;
    }

    public function handle(TableInterface $tableType, Request $request): array
    {
        assert($tableType instanceof OrmTableInterface);

        $params = $request->query->has('param') ? $request->query->all('param') : [];
        $repo = $this->doctrine->getRepository($tableType->getEntityClass());
        $qb = $tableType->getQueryBuilder($repo, $params);

        if ($tableType->getSortMode() === SortMode::REMOTE && $request->query->has('sort')) {
            $this->doctrineHelper->sort($qb, $request->query->all('sort'), $tableType->getSortOverride());
        }

        if ($tableType->getFilterMode() === FilterMode::REMOTE && $request->query->has('filter')) {
            $this->doctrineHelper->filter($qb, $request->query->all('filter'), $tableType->getFilterOverride());
        }

        $pagination = $tableType->getPagination();
        if (!$pagination || $pagination->getMode() === PaginationMode::LOCAL) {
            $query = $qb->getQuery();
            $tableType->configureQuery($query);
            $items = $query->getResult();
            $items = $tableType->doTransform($items);
            return $items;
        }

        $size = $request->query->getInt($pagination->getSizeParamName());
        $page = $request->query->getInt($pagination->getPageParamName());
        $this->doctrineHelper->paginate($qb, $size, $page);

        $query = $qb->getQuery();
        $tableType->configureQuery($query);
        $paginator = new DoctrinePaginator($query, false);

        $items = iterator_to_array($paginator->getIterator());
        $items = $tableType->doTransform($items);

        $count = $paginator->count();

        return [
            'last_row' => $count,
            'last_page' => (int) ceil($count / $size),
            'data' => $items,
        ];
    }
}
