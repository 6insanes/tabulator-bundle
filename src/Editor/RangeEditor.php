<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Editor;

use DeviantLab\TabulatorBundle\EditorInterface;

/**
 * The range editor allows for numeric entry with a range type input element.
 */
final class RangeEditor implements EditorInterface
{
    /**
     * @param int|null $min
     * The minimum allowed value
     * @param int|null $max
     * The maximum allowed value
     * @param int|null $step
     * The step size when incrementing/decrementing the value (default 1)
     * @param array|null $elementAttributes
     * Set attributes directly on the input element
     */
    public function __construct(
        private readonly ?int $min = null,
        private readonly ?int $max = null,
        private readonly ?int $step = null,
        private readonly ?array $elementAttributes = null,
    )
    {

    }

    public function getName(): string
    {
        return 'range';
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
        if ($this->elementAttributes) {
            $result['elementAttributes'] = $this->elementAttributes;
        }

        return $result;
    }
}
