<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Formatter;


use DeviantLab\TabulatorBundle\FormatterInterface;

final class RowSelectionFormatter implements FormatterInterface
{
    public function getName(): string
    {
        return 'rowSelection';
    }

    public function getParams(): array
    {
        return [];
    }
}
