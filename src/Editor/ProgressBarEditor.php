<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Editor;

use DeviantLab\TabulatorBundle\EditorInterface;

/**
 * The progress editor allows adjusting a numeric value formatted using the progress formatter.
 * This editor will automatically detect maximum and minimum values of the progress bar from the formatter, or they
 * can be manually overriden in the editorParams.
 */
final class ProgressBarEditor implements EditorInterface
{
    /**
     * @param int|null $min
     * The minimum value for the progress bar
     * @param int|null $max
     * The maximum value for the progress bar
     * @param array|null $elementAttributes
     * Set attributes directly on the input element
     */
    public function __construct(
        private readonly ?int $min = null,
        private readonly ?int $max = null,
        private readonly ?array $elementAttributes = null,
    )
    {

    }

    public function getName(): string
    {
        return 'progress';
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
        if ($this->elementAttributes) {
            $result['elementAttributes'] = $this->elementAttributes;
        }

        return $result;
    }
}
