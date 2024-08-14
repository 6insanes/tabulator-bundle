<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle;

interface FormatterInterface
{
    public function getName(): string;

    public function getParams(): array;
}
