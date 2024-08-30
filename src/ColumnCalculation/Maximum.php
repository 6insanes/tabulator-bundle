<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\ColumnCalculation;

/**
 * The max function displays the maximum value from all numerical cells in a column.
 */
final class Maximum implements ColumnCalculationInterface
{
    /**
     * @param int|null|false $precision
     * The number of decimals to display (default is 2), setting this value to false will display however many
     * decimals are provided with the number
     */
    public function __construct(
        private readonly int|null|bool $precision = null,
    )
    {

    }

    public function getName(): string
    {
        return 'max';
    }

    public function getParams(): array
    {
        $result = [];
        if ($this->precision !== null) {
            $result['precision'] = $this->precision;
        }

        return $result;
    }
}
