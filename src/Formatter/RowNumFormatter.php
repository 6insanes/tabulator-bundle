<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Formatter;


use DeviantLab\TabulatorBundle\FormatterInterface;

final class RowNumFormatter implements FormatterInterface
{
    public function __construct(
        private readonly bool $relativeToPage = false,
    )
    {

    }

    public function getName(): string
    {
        return 'rownum';
    }

    public function getParams(): array
    {
        return [
            'relativeToPage' => $this->relativeToPage,
        ];
    }
}
