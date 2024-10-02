<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Server;


use DeviantLab\TabulatorBundle\FilterMode;
use DeviantLab\TabulatorBundle\NativeTableInterface;
use DeviantLab\TabulatorBundle\PaginationMode;
use DeviantLab\TabulatorBundle\SortMode;
use DeviantLab\TabulatorBundle\TableInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

final class NativeTableHandler implements TableHandlerInterface
{
    public function __construct(
        private readonly ManagerRegistry $doctrine,
        private readonly DoctrineHelper $doctrineHelper,
    )
    {

    }

    public function supports(TableInterface $tableType): bool
    {
        return $tableType instanceof NativeTableInterface;
    }

    public function handle(TableInterface $tableType, Request $request): array
    {
        assert($tableType instanceof NativeTableInterface);

        $params = $request->query->has('param') ? $request->query->all('param') : [];
        $connection = $this->doctrine->getConnection($tableType->getConnectionName());
        $qb = $tableType->getQueryBuilder($connection, $params);
        $countQb = $tableType->getCountQueryBuilder($connection, $params);
        if (!$countQb) {
            $countQb = clone $qb;
            $countQb->select('COUNT(*)');
        }

        if ($tableType->getSortMode() === SortMode::REMOTE && $request->query->has('sort')) {
            $this->doctrineHelper->sort($qb, $request->query->all('sort'), $tableType->getSortOverride());
        }

        if ($tableType->getFilterMode() === FilterMode::REMOTE && $request->query->has('filter')) {
            $this->doctrineHelper->filter($qb, $request->query->all('filter'), $tableType->getFilterOverride());
            $this->doctrineHelper->filter($countQb, $request->query->all('filter'), $tableType->getFilterOverride());
        }

        $pagination = $tableType->getPagination();
        if (!$pagination || $pagination->getMode() === PaginationMode::LOCAL) {
            $items = $qb->fetchAllAssociative();
            $items = $tableType->doTransform($items, $params);
            return $items;
        }

        $size = $request->query->getInt($pagination->getSizeParamName());
        $page = $request->query->getInt($pagination->getPageParamName());
        $this->doctrineHelper->paginate($qb, $size, $page);

        $count = $countQb->fetchOne();
        $items = [];

        if ($count > 0) {
            $items = $qb->fetchAllAssociative();
            $items = $tableType->doTransform($items, $params);
        }

        return [
            'last_row' => $count,
            'last_page' => (int) ceil($count / $size),
            'data' => $items,
        ];
    }
}
