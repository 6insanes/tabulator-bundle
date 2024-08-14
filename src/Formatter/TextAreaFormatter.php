<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Formatter;


use DeviantLab\TabulatorBundle\FormatterInterface;

final class TextAreaFormatter implements FormatterInterface
{
    public function getName(): string
    {
        return 'textarea';
    }

    public function getParams(): array
    {
        return [];
    }
}
