<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Editor;

use DeviantLab\TabulatorBundle\EditorInterface;

/**
 * The tickCross editor allows for boolean values using a checkbox type input element.
 */
final class CheckboxEditor implements EditorInterface
{
    /**
     * @param string|null $trueValue
     * The value returned from the editor when the checkbox is ticked (leave undefined for standard boolean values)
     * @param string|null $falseValue
     * The value returned from the editor when the checkbox is unticked (leave undefined for standard boolean values)
     * @param bool|null $tristate
     * Allow tristate tickbox (default false)
     * @param string|null $indeterminateValue
     * When using tristate tickbox what value should the third indeterminate state have (default null)
     * @param array|null $elementAttributes
     * Set attributes directly on the input element
     */
    public function __construct(
        private readonly ?string $trueValue = null,
        private readonly ?string $falseValue = null,
        private readonly ?bool $tristate = null,
        private readonly ?string $indeterminateValue = null,
        private readonly ?array $elementAttributes = null,
    )
    {

    }

    public function getName(): string
    {
        return 'tickCross';
    }

    public function getParams(): array
    {
        $result = [];
        if ($this->trueValue) {
            $result['trueValue'] = $this->trueValue;
        }
        if ($this->falseValue) {
            $result['falseValue'] = $this->falseValue;
        }
        if ($this->tristate) {
            $result['tristate'] = $this->tristate;
        }
        if ($this->indeterminateValue) {
            $result['indeterminateValue'] = $this->indeterminateValue;
        }
        if ($this->elementAttributes) {
            $result['elementAttributes'] = $this->elementAttributes;
        }

        return $result;
    }
}
