<?php

declare(strict_types=1);


namespace DeviantLab\TabulatorBundle;

use Symfony\UX\StimulusBundle\Dto\StimulusAttributes;
use Table\Action\ActionButtonInterface;
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
            new TwigFunction('table_action_attrs', [$this, 'renderActionAttributes'], [
                'needs_environment' => true,
                'is_safe' => ['html'],
            ])
        ];
    }

    public function renderTable(Environment $twig, Table $table): string
    {
        $adapter = new TabulatorAdapter($table);

        return $twig->render('_partials/tabulator_table.html.twig', [
            'table' => $table,
            'options' => $adapter->getOptions(),
        ]);
    }

    public function renderActionAttributes(Environment $environment, ActionButtonInterface $actionButton): string
    {
        $stimulusAttributes = new StimulusAttributes($environment);
        $stimulusAttributes->addTarget('tabulator-actions', 'action');
        $stimulusAttributes->addAttribute('title', $actionButton->getTitle());
        foreach ($actionButton->getAttrs() as $name => $value) {
            $stimulusAttributes->addAttribute($name, $value);;
        }

        return (string)$stimulusAttributes;
    }
}
