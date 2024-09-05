<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle;

final class HeaderFilter
{
    public const INITIAL_UNDEFINED = '__INITIAL_UNDEFINED';

    public function __construct(
        public readonly EditorInterface $editor,
        public readonly FilterFunction $filterFunction,
        public readonly mixed $initial = self::INITIAL_UNDEFINED,
        public readonly ?string $placeholder = null,
    )
    {

    }
}
