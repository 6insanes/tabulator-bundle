<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Sorter;

/**
 * The alphanum sorter will sort column as alphanumeric code
 */
final class AlphanumericSorter implements SorterInterface
{
    /**
     * @param AlignEmptyValues|null $alignEmptyValues
     * force empty cells to top or bottom of table regardless of sort order
     */
    public function __construct(
        private readonly ?AlignEmptyValues $alignEmptyValues = null,
    )
    {

    }

    public function getName(): string
    {
        return 'alphanum';
    }

    public function getParams(): array
    {
        $result = [];

        if ($this->alignEmptyValues) {
            $result['alignEmptyValues'] = $this->alignEmptyValues;
        }

        return $result;
    }
}
