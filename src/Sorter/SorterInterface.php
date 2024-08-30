<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Sorter;

interface SorterInterface
{
    public function getName(): string;

    public function getParams(): array;
}
