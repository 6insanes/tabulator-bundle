<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\FilterFunction;


use DeviantLab\TabulatorBundle\FilterFunctionInterface;

final class Regex implements FilterFunctionInterface
{
    public function getName(): string
    {
        return 'regex';
    }
}