<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle;

final class HeaderFilter
{
    public function __construct(
        public readonly EditorInterface $editor,
        public readonly FilterFunctionInterface $filterFunction,
        public readonly ?string $placeholder = null,
    )
    {

    }
}
