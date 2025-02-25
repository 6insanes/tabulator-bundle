<?php

declare(strict_types=1);


namespace DeviantLab\TabulatorBundle;

use Symfony\UX\StimulusBundle\Dto\StimulusAttributes;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class TableTwigExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('render_table', [$this, 'renderTable'], [
                'needs_environment' => true,
                'is_safe' => ['html'],
            ]),
        ];
    }

    public function renderTable(Environment $twig, Table $table, ?StimulusAttributes $stimulusAttributes = null): string
    {
        $adapter = new TabulatorAdapter($table);
        $stimulusAttributes = $stimulusAttributes ?? new StimulusAttributes($twig);
        $stimulusAttributes->addController('deviantlab--tabulator-bundle--tabulator', [
            'options' => $adapter->getOptions(),
        ]);

        return $twig->render('@DeviantlabTabulator/tabulator.html.twig', [
            'stimulusAttributes' => $stimulusAttributes,
        ]);
    }
}
