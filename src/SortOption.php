<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle;


final class SortOption
{
    public function __construct(
        public readonly string $column,
        public readonly SortDirection $dir,
    )
    {

    }
}
