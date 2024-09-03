<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Editor;

use DeviantLab\TabulatorBundle\EditorInterface;

/**
 * The number editor allows for numeric entry with a number type input element with increment and decrement buttons.
 */
final class NumberEditor implements EditorInterface
{
    /**
     * @param int|null $min
     * The minimum allowed value
     * @param int|null $max
     * The maximum allowed value
     * @param int|null $step
     * The step size when incrementing/decrementing the value (default 1)
     * @param string|null $mask
     * Apply a mask to the input to allow characters to be entered only in a certain order
     * @param bool|null $selectContents
     * When the editor is loaded select its text content
     * @param array|null $elementAttributes
     * Set attributes directly on the input element
     * @param VerticalNavigation|null $verticalNavigation
     * Determine how use of the up/down arrow keys will affect the editor
     */
    public function __construct(
        private readonly ?int $min = null,
        private readonly ?int $max = null,
        private readonly ?int $step = null,
        private readonly ?string $mask = null,
        private readonly ?bool $selectContents = null,
        private readonly ?array $elementAttributes = null,
        private readonly ?VerticalNavigation $verticalNavigation = null,
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
        if ($this->min) {
            $result['min'] = $this->min;
        }
        if ($this->max) {
            $result['max'] = $this->max;
        }
        if ($this->step) {
            $result['step'] = $this->step;
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
        if ($this->verticalNavigation) {
            $result['verticalNavigation'] = $this->verticalNavigation->value;
        }

        return $result;
    }
}
