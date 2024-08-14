<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Formatter;


use DeviantLab\TabulatorBundle\FormatterInterface;

final class MoneyFormatter implements FormatterInterface
{
    public function __construct(
        private readonly string $decimal = ',',
        private readonly string $thousand = '.',
        private readonly string $symbol = '£',
        private readonly string $symbolAfter = 'p',
        private readonly bool $negativeSign = true,
        private readonly bool $precision = false,
    )
    {

    }

    public function getName(): string
    {
        return 'money';
    }

    public function getParams(): array
    {
        return [
            'decimal' => $this->decimal,
            'thousand' => $this->thousand,
            'symbol' => $this->symbol,
            'symbolAfter' => $this->symbolAfter,
            'negativeSign' => $this->negativeSign,
            'precision' => $this->precision,
        ];
    }
}
