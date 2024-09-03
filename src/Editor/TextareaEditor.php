<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Editor;

use DeviantLab\TabulatorBundle\EditorInterface;

/**
 * The textarea editor allows entering of multiple lines of plain text
 */
final class TextareaEditor implements EditorInterface
{
    /**
     * @param VerticalNavigation|null $verticalNavigation
     * Determine how use of the up/down arrow keys will affect the editor
     * @param bool|null $shiftEnterSubmit
     * Submit the cell value when the shift and enter keys are pressed
     * @param string|null $mask
     * Apply a mask to the input to allow characters to be entered only in a certain order
     * @param bool|null $selectContents
     * When the editor is loaded select its text content
     * @param array|null $elementAttributes
     * Set attributes directly on the input element
     */
    public function __construct(
        private readonly ?VerticalNavigation $verticalNavigation = null,
        private readonly ?bool $shiftEnterSubmit = null,
        private readonly ?string $mask = null,
        private readonly ?bool $selectContents = null,
        private readonly ?array $elementAttributes = null,
    )
    {

    }

    public function getName(): string
    {
        return 'textarea';
    }

    public function getParams(): array
    {
        $result = [];
        if ($this->verticalNavigation) {
            $result['verticalNavigation'] = $this->verticalNavigation->value;
        }
        if ($this->shiftEnterSubmit) {
            $result['shiftEnterSubmit'] = $this->shiftEnterSubmit;
        }
        if ($this->mask) {
            $result['mask'] = $this->mask;
        }
        if ($this->selectContents) {
            $result['selectContents'] = $this->selectContents;
        }
        if ($this->elementAttributes) {
            $result['elementAttributes'] = $this->elementAttributes;
        }

        return $result;
    }
}
