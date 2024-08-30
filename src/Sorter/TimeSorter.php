<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Sorter;

/**
 * The time sorter will sort columns as times
 */
final class TimeSorter implements SorterInterface
{
    /**
     * @param string|null $format
     * The format of the time (default: HH:mm).
     * This accepts any valid Luxon format string, or the value "iso" which accept any
     * ISO formatted data. If the input value is a luxon DateTime object then you can
     * ignore this option.
     *
     * @param AlignEmptyValues|null $alignEmptyValues
     * Force empty cells to top or bottom of table regardless of sort order
     */
    public function __construct(
        private readonly ?string $format = null,
        private readonly ?AlignEmptyValues $alignEmptyValues = null,
    )
    {

    }

    public function getName(): string
    {
        return 'time';
    }

    public function getParams(): array
    {
        $result = [];
        if ($this->format) {
            $result['format'] = $this->format;
        }
        if ($this->alignEmptyValues) {
            $result['alignEmptyValues'] = $this->alignEmptyValues;
        }

        return $result;
    }
}
