<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Editor;

use DeviantLab\TabulatorBundle\EditorInterface;

/**
 * The star editor allows entering of numeric value using a star rating indicator.
 * This editor will automatically detect the correct number of stars to use if it is used on the same column as the star formatter.
 * Users can use left/right arrow keys and enter for selection as well as the mouse.
 */
final class StarRatingEditor implements EditorInterface
{
    /**
     * @param array|null $elementAttributes
     * Set attributes directly on the input element
     */
    public function __construct(
        private readonly ?array $elementAttributes = null,
    )
    {

    }

    public function getName(): string
    {
        return 'star';
    }

    public function getParams(): array
    {
        $result = [];
        if ($this->elementAttributes) {
            $result['elementAttributes'] = $this->elementAttributes;
        }

        return $result;
    }
}
