<?php

declare(strict_types=1);


namespace DeviantLab\TabulatorBundle;

use DeviantLab\TabulatorBundle\Server\Filter\FilterOverride;
use DeviantLab\TabulatorBundle\Server\Sorter\SortOverride;

interface TableInterface
{
    public static function getName(): string;

    /**
     * @return iterable<Column>
     */
    public function getColumns(): iterable;

    public function getPagination(): ?Pagination;

    public function getSortMode(): SortMode;

    public function getSortOverride(): ?SortOverride;

    public function getFilterMode(): FilterMode;

    public function getFilterOverride(): ?FilterOverride;

    public function configureTable(Table $table): void;

    public function doTransform(array $items): array;
}
