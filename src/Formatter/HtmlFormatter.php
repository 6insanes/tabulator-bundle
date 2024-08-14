<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Formatter;


use DeviantLab\TabulatorBundle\FormatterInterface;

final class HtmlFormatter implements FormatterInterface
{
    public function getName(): string
    {
        return 'html';
    }

    public function getParams(): array
    {
        return [];
    }
}
