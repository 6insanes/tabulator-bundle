<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Formatter;


use DeviantLab\TabulatorBundle\FormatterInterface;

final class DateTimeFormatter implements FormatterInterface
{
    public function __construct(
        private readonly string $inputFormat = 'iso',
        private readonly string $outputFormat = 'dd.MM.yyyy',
        private readonly string $invalidPlaceholder = '(invalid date)',
        private readonly string $timezone = 'America/Los_Angeles',
    )
    {

    }

    public function getName(): string
    {
        return 'datetime';
    }

    public function getParams(): array
    {
        return [
            'inputFormat' => $this->inputFormat,
            'outputFormat' => $this->outputFormat,
            'invalidPlaceholder' => $this->invalidPlaceholder,
            'timezone' => $this->timezone,
        ];
    }
}
