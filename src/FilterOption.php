<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle;


final class FilterOption
{
    public function __construct(
        public readonly string $field,
        public readonly string $type,
        public readonly mixed $value,
    )
    {

    }
}
