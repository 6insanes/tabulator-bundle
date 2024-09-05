<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class TableFactory
{
    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly ContainerInterface $locator,
    )
    {
    }

    /**
     * @param string $tableTypeClass
     * @param array|null $params
     * @return Table
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function create(string $tableTypeClass, ?array $params = null): Table
    {
        if (!$this->locator->has($tableTypeClass)) {
            throw new \InvalidArgumentException("{$tableTypeClass} not found");
        }

        /** @var TableInterface $tableType */
        $tableType = $this->locator->get($tableTypeClass);

        return $this->createTable($tableType, $params);
    }

    public function createTable(TableInterface $tableType, ?array $params = null): Table
    {
        $table = new Table();
        foreach ($tableType->getColumns() as $column) {
            $table->addColumn($column);
        }

        $ajax = new Ajax(
            url: $this->urlGenerator->generate('deviantlab_tabulatorbundle_get_data', [
                '_tableName' => call_user_func([$tableType, 'getName']),
            ]),
            params: $params ? ['param' => $params] : null,
            method: 'GET',
        );
        $table->setAjax($ajax);

        $pagination = $tableType->getPagination();
        if ($pagination) {
            $table->setPagination($pagination);
        }

        $table->setSortMode($tableType->getSortMode());
        $table->setFilterMode($tableType->getFilterMode());

        $tableType->configureTable($table);

        return $table;
    }
}
