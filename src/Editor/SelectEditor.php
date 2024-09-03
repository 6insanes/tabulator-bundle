<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Editor;

use DeviantLab\TabulatorBundle\EditorInterface;
use DeviantLab\TabulatorBundle\SortDirection;

/**
 * The list editor creates a dropdown list to allow the user to select from some predefined options, by default it
 * functions as a select list type element but can also be configured to function as an autocomplete.
 */
final class SelectEditor implements EditorInterface
{
    /**
     * @param array|null $values
     * Either an array of values, or value objects (this is explained in more detail in the next section)
     * @param string|null $valuesUrl
     * The url to load the values for the list from
     * @param string|null $valuesLookup
     * Lookup the values for the list from a column in the table, this option sets which range of data should be loaded,
     * or provides a function to dynamically set the data
     * @param string|null $valuesLookupField
     * The field the values for this list should be looked up from
     * @param bool|null $clearable
     * Adds a clear button to the right of the editor to allow the user to empty the current value
     * @param array|null $elementAttributes
     * Set attributes directly on the input element
     * @param VerticalNavigation|null $verticalNavigation
     * Determine how use of the up/down arrow keys will affect the editor
     * @param SortDirection|null $sort
     * Sort the items in the list, either asc or desc or a custom sorter function
     * @param string|null $defaultValue
     * Set the value that should be selected by default if the cells value is undefined
     * @param string|null $emptyValue
     * Set the value that will be set on the cell if the user leave the input empty
     * @param bool|null $maxWidth
     * The list will by default expand to fit the contents of the list, if you wish to constrain the width of the list,
     * you can either pass an integer for the maximum width of the list in pixels, or the value true which will fit the
     * list to the width of the current cell
     * @param string|null $placeholderLoading
     * Set custom placeholder when loading list values, this can either be a text string, a valid HTML string a DOM
     * Element, or a function, that will be called and passed in the cell component and the current list element and
     * should return one of the above valid placeholder values.
     * @param string|null $placeholderEmpty
     * Set custom placeholder when list is empty, this can either be a text string, a valid HTML string a DOM Element,
     * or a function, that will be called and passed in the cell component and the current list element and should
     * return one of the above valid placeholder values.
     * @param bool|null $multiselect
     * Set this to true to allow the user to choose multiple values. With this option enabled the editor will accept and
     * return an array of values. (this option is only available when the autocomplete option is disabled)
     * @param bool|null $autocomplete
     * Set this to true to allow the user to filter the options list by typing in the input.
     * @param bool|null $filterRemote
     * When using a remote data source like Ajax, this tells hte auto complete to submit the search term as part of the
     * request instead of triggering a local filter function. (this option is only available when the autocomplete
     * option is enabled)
     * @param int|null $filterDelay
     * The delay in milliseconds between a person typing a letter and the filter begginging, used to delay filtering
     * until the user has finished typing. (default value 300 - this option is only available when the autocomplete
     * option is enabled)
     * @param bool|null $allowEmpty
     * Allow the user to save an empty value to the cell. (this option is only available when the autocomplete option is
     * enabled)
     * @param bool|null $listOnEmpty
     * Show the whole list of values when the cell is empty. (this option is only available when the autocomplete option
     * is enabled)
     * @param string|null $mask
     * Apply a mask to the input to allow characters to be entered only in a certain order
     * @param bool|null $freetext
     * Allow the user to press enter to save a value to the cell that is not in the list (this option is only available
     * when the autocomplete option is enabled)
     */
    public function __construct(
        private readonly ?array $values = null,
        private readonly ?string $valuesUrl = null,
        private readonly ?string $valuesLookup = null,

        private readonly ?string $valuesLookupField = null,

        private readonly ?bool $clearable = null,
        private readonly ?array $elementAttributes = null,
        private readonly ?VerticalNavigation $verticalNavigation = null,
        private readonly ?SortDirection $sort = null,
        private readonly ?string $defaultValue = null,
        private readonly ?string $emptyValue = null,
        private readonly ?bool $maxWidth = null,
        private readonly ?string $placeholderLoading = null,
        private readonly ?string $placeholderEmpty = null,

        private readonly ?bool $multiselect = null,

        private readonly ?bool $autocomplete = null,
        private readonly ?bool $filterRemote = null,
        private readonly ?int $filterDelay = null,
        private readonly ?bool $allowEmpty = null,
        private readonly ?bool $listOnEmpty = null,

        private readonly ?string $mask = null,
        private readonly ?bool $freetext = null,
    )
    {
        $valueOptions = [$this->values, $this->valuesUrl, $this->valuesLookup];
        $filteredValueOptions = \array_filter($valueOptions);
        if (\count($filteredValueOptions) > 1) {
            throw new \InvalidArgumentException('You should use only ONE value option per editor');
        }
        if (\count($filteredValueOptions) === 0) {
            throw new \InvalidArgumentException('You should provide ONE value option');
        }
    }

    public function getName(): string
    {
        return 'list';
    }

    public function getParams(): array
    {
        $result = [];
        if ($this->values) {
            $result['values'] = $this->values;
        }
        if ($this->valuesUrl) {
            $result['valuesUrl'] = $this->valuesUrl;
        }
        if ($this->valuesLookup) {
            $result['valuesLookup'] = $this->valuesLookup;
        }
        if ($this->valuesLookupField) {
            $result['valuesLookupField'] = $this->valuesLookupField;
        }
        if ($this->clearable) {
            $result['clearable'] = $this->clearable;
        }
        if ($this->elementAttributes) {
            $result['elementAttributes'] = $this->elementAttributes;
        }
        if ($this->verticalNavigation) {
            $result['verticalNavigation'] = $this->verticalNavigation->value;
        }
        if ($this->sort) {
            $result['sort'] = $this->sort->value;
        }
        if ($this->defaultValue) {
            $result['defaultValue'] = $this->defaultValue;
        }
        if ($this->emptyValue) {
            $result['emptyValue'] = $this->emptyValue;
        }
        if ($this->maxWidth) {
            $result['maxWidth'] = $this->maxWidth;
        }
        if ($this->placeholderLoading) {
            $result['placeholderLoading'] = $this->placeholderLoading;
        }
        if ($this->placeholderEmpty) {
            $result['placeholderEmpty'] = $this->placeholderEmpty;
        }
        if ($this->multiselect) {
            $result['multiselect'] = $this->multiselect;
        }
        if ($this->autocomplete) {
            $result['autocomplete'] = $this->autocomplete;
        }
        if ($this->filterRemote) {
            $result['filterRemote'] = $this->filterRemote;
        }
        if ($this->filterDelay) {
            $result['filterDelay'] = $this->filterDelay;
        }
        if ($this->allowEmpty) {
            $result['allowEmpty'] = $this->allowEmpty;
        }
        if ($this->listOnEmpty) {
            $result['listOnEmpty'] = $this->listOnEmpty;
        }
        if ($this->mask) {
            $result['mask'] = $this->mask;
        }
        if ($this->freetext) {
            $result['freetext'] = $this->freetext;
        }

        return $result;
    }
}
