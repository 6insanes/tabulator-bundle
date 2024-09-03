<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Editor;

use DeviantLab\TabulatorBundle\EditorInterface;

/**
 * The date editor allows for editing of a date using a standard date type input field.
 */
final class DateEditor implements EditorInterface
{
    /**
     * @param string|null $min
     * The earliest day available for the date picker, the default format is yyyy-mm-dd, if the format param is used
     * then it will expect the date in that format instead
     * @param string|null $max
     * The latest day available for the date picker, the default is yyyy-mm-dd, if the format param is used then it
     * will expect the date in that format instead
     * @param string|null $format
     * The format for the date to be stored in the table. This accepts any valid Luxon format string, or the value
     * "iso" which accept any ISO formatted data. If the input value is a luxon DateTime object then you should set
     * this option to true. If this value param is ignored then the data should be in the format YYYY-MM-DD
     * (this will not affect the format the user has to enter the data into the table, that is determined by the
     * browser)
     * @param VerticalNavigation|null $verticalNavigation
     * Determine how use of the up/down arrow keys will affect the editor
     * @param array|null $elementAttributes
     * Set attributes directly on the input element
     */
    public function __construct(
        private readonly ?string $min = null,
        private readonly ?string $max = null,
        private readonly ?string $format = null,
        private readonly ?VerticalNavigation $verticalNavigation = null,
        private readonly ?array $elementAttributes = null,
    )
    {

    }

    public function getName(): string
    {
        return 'date';
    }

    public function getParams(): array
    {
        $result = [];
        if ($this->min) {
            $result['min'] = $this->min;
        }
        if ($this->max) {
            $result['max'] = $this->max;
        }
        if ($this->format) {
            $result['format'] = $this->format;
        }
        if ($this->verticalNavigation) {
            $result['verticalNavigation'] = $this->verticalNavigation->value;
        }
        if ($this->elementAttributes) {
            $result['elementAttributes'] = $this->elementAttributes;
        }

        return $result;
    }
}
