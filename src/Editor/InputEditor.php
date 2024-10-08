<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Editor;

use DeviantLab\TabulatorBundle\EditorInterface;

/**
 * The input editor allows entering of a single line of plain text
 */
final class InputEditor implements EditorInterface
{
    /**
     * @param bool|null $search
     * Use search type input element with clear button
     * @param string|null $mask
     * Apply a mask to the input to allow characters to be entered only in a certain order
     * @param bool|null $selectContents
     * When the editor is loaded select its text content
     * @param array|null $elementAttributes
     * Set attributes directly on the input element
     */
    public function __construct(
        private readonly ?bool $search = null,
        private readonly ?string $mask = null,
        private readonly ?bool $selectContents = null,
        private readonly ?array $elementAttributes = null,
    )
    {

    }

    public function getName(): string
    {
        return 'input';
    }

    public function getParams(): array
    {
        $result = [];
        if ($this->search) {
            $result['search'] = $this->search;
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
