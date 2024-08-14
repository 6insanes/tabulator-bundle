<?php

declare(strict_types=1);


namespace DeviantLab\TabulatorBundle;

final class RowHeader
{
    public function __construct(
        public readonly ?FormatterInterface $formatter = null,
        public readonly ?bool               $headerSort = null,
        public readonly ?HozAlign           $hozAlign = null,
        public readonly ?VertAlign          $vertAlign = null,
        public readonly ?bool               $resizable = null,
        public readonly ?bool               $frozen = null,
    )
    {

    }
}
