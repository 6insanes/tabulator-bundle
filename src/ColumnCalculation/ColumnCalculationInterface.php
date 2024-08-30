<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\ColumnCalculation;

interface ColumnCalculationInterface
{
    public function getName(): string;

    public function getParams(): array;
}
