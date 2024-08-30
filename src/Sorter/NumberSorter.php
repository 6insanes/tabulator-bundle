<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Sorter;


/**
 * The number sorter will sort column as numbers (integer or float, will also handle numbers using "," separators)
 */
final class NumberSorter implements SorterInterface
{
    /**
     * @param string|null $thousandSeparator
     * If using a thousand separator character in your numbers (eg 1,024.00),
     * then set it in this property to ensure the sorter works correctly
     *
     * @param string|null $decimalSeparator
     * If you are using a decimal separator other than the standard "." (eg 1,45)
     * then set it in this property to ensure the sorter works correctly
     *
     * @param AlignEmptyValues|null $alignEmptyValues
     * Force empty cells to top or bottom of table regardless of sort order
     */
    public function __construct(
        private readonly ?string $thousandSeparator = null,
        private readonly ?string $decimalSeparator = null,
        private readonly ?AlignEmptyValues $alignEmptyValues = null,
    )
    {

    }

    public function getName(): string
    {
        return 'number';
    }

    public function getParams(): array
    {
        $result = [];
        if ( $this->thousandSeparator) {
            $result['thousandSeparator'] = $this->thousandSeparator;
        }
        if ($this->decimalSeparator) {
            $result['decimalSeparator'] = $this->decimalSeparator;
        }
        if ($this->alignEmptyValues) {
            $result['alignEmptyValues'] = $this->alignEmptyValues;
        }

        return $result;
    }
}
