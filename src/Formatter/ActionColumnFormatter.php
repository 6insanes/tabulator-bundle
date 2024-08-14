<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Formatter;


use DeviantLab\TabulatorBundle\FormatterInterface;

final class ActionColumnFormatter implements FormatterInterface
{
    public function __construct(
        private readonly bool $edit = true,
    )
    {

    }

    public function getName(): string
    {
        return 'action';
    }

    public function getParams(): array
    {
        return [
            'edit' => $this->edit,
        ];
    }
}
