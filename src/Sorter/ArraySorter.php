<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Sorter;

/**
 * The array sorter will sort arrays of data
 */
final class ArraySorter implements SorterInterface
{
    /**
     * @param ArrayComparisonType|null $type
     * Arrays will be sorted by length by default
     *
     * @param AlignEmptyValues|null $alignEmptyValues
     * Force empty cells to top or bottom of table regardless of sort order
     */
    public function __construct(
        private readonly ?ArrayComparisonType $type = null,
        private readonly ?AlignEmptyValues $alignEmptyValues = null,
    )
    {

    }

    public function getName(): string
    {
        return 'array';
    }

    public function getParams(): array
    {
        $result = [];
        if ($this->type) {
            $result['type'] = $this->type;
        }
        if ($this->alignEmptyValues) {
            $result['alignEmptyValues'] = $this->alignEmptyValues;
        }

        return $result;
    }
}
