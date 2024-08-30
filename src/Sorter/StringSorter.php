<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Sorter;

/**
 * The string sorter will sort columns as strings of characters
 */
final class StringSorter implements SorterInterface
{
    /**
     * @param string|true|null $locale
     * The locale code for the string comparison function, (without this the sorter will use the locale of the browser)
     *
     * It can accept:
     *
     * string - the locale code for the sort
     * boolean - set the value to true to use the current table locale
     *
     * @param AlignEmptyValues|null $alignEmptyValues
     * Force empty cells to top or bottom of table regardless of sort order
     */
    public function __construct(
        private readonly string|bool|null $locale = null,
        private readonly ?AlignEmptyValues $alignEmptyValues = null,
    )
    {

    }

    public function getName(): string
    {
        return 'string';
    }

    public function getParams(): array
    {
        $result = [];
        if ($this->locale) {
            $result['locale'] = $this->locale;
        }

        if ($this->alignEmptyValues) {
            $result['alignEmptyValues'] = $this->alignEmptyValues;
        }

        return $result;
    }
}
