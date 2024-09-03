<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Editor;

use DeviantLab\TabulatorBundle\EditorInterface;

/**
 * The datetime editor allows for editing of a date and time using a standard datetime type input field.
 */
final class DateTimeEditor implements EditorInterface
{
    /**
     * @param string|null $format
     * The format for the date-time to be stored in the table. This accepts any valid Luxon format string, or the value
     * "iso" which accept any ISO formatted data. If the input value is a luxon DateTime object then you should set this
     * option to true. If this value param is ignored then the data should be in the format YYYY-MM-DDThh:mm(this will
     * not affect the format the user has to enter the data into the table, that is determined by the browser)
     * @param VerticalNavigation|null $verticalNavigation
     * Determine how use of the up/down arrow keys will affect the editor
     * @param array|null $elementAttributes
     * Set attributes directly on the input element
     */
    public function __construct(
        private readonly ?string             $format = null,
        private readonly ?VerticalNavigation $verticalNavigation = null,
        private readonly ?array              $elementAttributes = null,
    )
    {

    }

    public function getName(): string
    {
        return 'datetime';
    }

    public function getParams(): array
    {
        $result = [];
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
