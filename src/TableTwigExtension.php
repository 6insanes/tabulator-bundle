<?php

declare(strict_types=1);


namespace DeviantLab\TabulatorBundle;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class TableTwigExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('render_table', [$this, 'renderTable'], [
                'needs_environment' => true,
                'is_safe' => ['html'],
            ]),
        ];
    }

    public function renderTable(Environment $twig, Table $table): string
    {
        $adapter = new TabulatorAdapter($table);

        return $twig->render('@DeviantlabTabulator/tabulator.html.twig', [
            'table' => $table,
            'options' => $adapter->getOptions(),
        ]);
    }
}
