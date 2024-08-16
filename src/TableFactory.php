<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle;

use Doctrine\Persistence\ManagerRegistry;
use Psr\Container\ContainerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class TableFactory
{
    public function __construct(
        private readonly ManagerRegistry $doctrine,
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly ContainerInterface $locator,
    )
    {
    }

    /**
     * @phpstan-param class-string<OrmTableInterface> $tableTypeClass
     * @param string $tableTypeClass
     * @return Table
     */
    public function create(string $tableTypeClass): Table
    {
        if (!$this->locator->has($tableTypeClass)) {
            throw new \InvalidArgumentException("{$tableTypeClass} not found");
        }

        /** @var OrmTableInterface $tableType */
        $tableType = $this->locator->get($tableTypeClass);

        dump($tableType);

        $table = new Table();
        foreach ($tableType->getColumns() as $column) {
            $table->addColumn($column);
        }

        $table->setAjax(new Ajax(
            url: $this->urlGenerator->generate('deviantlab_tabulatorbundle_get_data', [
                '_tableName' => call_user_func([$tableType, 'getName']),
            ]),
            method: 'GET',
        ));

        return $table;
    }
}
