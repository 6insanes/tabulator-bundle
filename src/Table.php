<?php

declare(strict_types=1);


namespace DeviantLab\TabulatorBundle;

use DeviantLab\TabulatorBundle\ColumnCalculation\CalculationVisibility;

final class Table implements TableInterface
{
    private ?Layout $layout = null;

    private string|int|null $height = null;

    private string|int|null $maxHeight = null;

    private string|int|null $minHeight = null;

    /**
     * @var array<string, Column>
     */
    private array $columns = [];

    /**
     * @var array<string, bool>
     */
    private array $fields = [];

    private ?array $data = null;

    private bool $dataTree = false;

    private bool $dataTreeStartExpanded = false;

    private bool $dataTreeFilter = true;

    private bool $dataTreeSort = true;

    private string $placeholder = 'Нет данных';

    private FilterMode $filterMode = FilterMode::LOCAL;

    private SortMode $sortMode = SortMode::LOCAL;

    private ?InitialSortCollection $initialSort = null;

    private ?bool $columnHeaderSortMulti = null;

    private ?HeaderSortClickElement $headerSortClickElement = null;

    private ?string $headerSortElement = null;

    private ?Pagination $pagination = null;

    private ?Ajax $ajax;

    private string|bool|null $popupContainer = null;

    private ?CalculationVisibility $columnCalcs = null;

    private bool $groupClosedShowCalcs = false;

    private bool $dataTreeChildColumnCalcs = false;

    public function __construct(
        private ?string                    $printHeader = null,
        private readonly ?int              $rowHeight = null,
        private readonly ?bool             $layoutColumnsOnNewData = null,
        private readonly string            $locale = 'ru',
        private readonly ?EditTriggerEvent $editTriggerEvent = null,

        /**
         * Enabled by default
         * https://tabulator.info/docs/6.2/layout#resize-table
         *
         * @var bool|null
         */
        private readonly ?bool             $autoResize = null,
        private readonly ?bool             $resizableColumnFit = null,
        private readonly ?bool             $selectableRows = null,
        ?Ajax                              $ajax = null,
        ?Pagination                        $pagination = null,
        private readonly ?RowHeader        $rowHeader = null,
    )
    {
        $this->ajax = $ajax;
        $this->setPagination($pagination);
    }

    public function getLayout(): ?Layout
    {
        return $this->layout;
    }

    public function setLayout(?Layout $layout): self
    {
        $this->layout = $layout;

        return $this;
    }

    public function getHeight(): string|int|null
    {
        return $this->height;
    }

    public function setHeight(string|int|null $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getMaxHeight(): string|int|null
    {
        return $this->maxHeight;
    }

    public function setMaxHeight(string|int|null $maxHeight): self
    {
        $this->maxHeight = $maxHeight;

        return $this;
    }

    public function getMinHeight(): string|int|null
    {
        return $this->minHeight;
    }

    public function setMinHeight(string|int|null $minHeight): self
    {
        $this->minHeight = $minHeight;

        return $this;
    }

    public function getRowHeight(): ?int
    {
        return $this->rowHeight;
    }

    public function addColumn(Column $column): self
    {
        if ($column->field && array_key_exists($column->field, $this->fields)) {
            throw new \InvalidArgumentException('Duplicate column with field ' . $column->field);
        }

        if ($column->field) {
            $this->fields[$column->field] = true;
        }

        $this->columns[] = $column;

        return $this;
    }

    /**
     * @return array<string, Column>
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getData(): ?array
    {
        return $this->data;
    }

    public function isDataTree(): bool
    {
        return $this->dataTree;
    }

    public function setDataTree(bool $dataTree): self
    {
        $this->dataTree = $dataTree;

        return $this;
    }

    public function isDataTreeStartExpanded(): bool
    {
        return $this->dataTreeStartExpanded;
    }

    public function setDataTreeStartExpanded(bool $dataTreeStartExpanded): void
    {
        $this->dataTreeStartExpanded = $dataTreeStartExpanded;
    }

    public function isDataTreeFilter(): bool
    {
        return $this->dataTreeFilter;
    }

    public function setDataTreeFilter(bool $dataTreeFilter): void
    {
        $this->dataTreeFilter = $dataTreeFilter;
    }

    public function isDataTreeSort(): bool
    {
        return $this->dataTreeSort;
    }

    public function setDataTreeSort(bool $dataTreeSort): void
    {
        $this->dataTreeSort = $dataTreeSort;
    }

    public function setPlaceholder(string $placeholder): self
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    public function getPagination(): ?Pagination
    {
        return $this->pagination;
    }

    public function setPagination(?Pagination $pagination): self
    {
        $pagination?->validate($this);
        $this->pagination = $pagination;

        return $this;
    }

    public function getLayoutColumnsOnNewData(): ?bool
    {
        return $this->layoutColumnsOnNewData;
    }

    public function getAutoResize(): ?bool
    {
        return $this->autoResize;
    }

    public function getResizableColumnFit(): ?bool
    {
        return $this->resizableColumnFit;
    }

    public function getRowHeader(): ?RowHeader
    {
        return $this->rowHeader;
    }

    public function getSelectableRows(): ?bool
    {
        return $this->selectableRows;
    }

    public function getPrintHeader(): ?string
    {
        return $this->printHeader;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getEditTriggerEvent(): ?EditTriggerEvent
    {
        return $this->editTriggerEvent;
    }

    public function getAjax(): ?Ajax
    {
        return $this->ajax;
    }

    public function setAjax(?Ajax $ajax): self
    {
        $this->ajax = $ajax;

        return $this;
    }

    public function getSortMode(): SortMode
    {
        return $this->sortMode;
    }

    public function setSortMode(SortMode $sortMode): self
    {
        $this->sortMode = $sortMode;

        return $this;
    }

    public function getInitialSort(): ?InitialSortCollection
    {
        return $this->initialSort;
    }

    public function setInitialSort(?InitialSortCollection $initialSort): self
    {
        $this->initialSort = $initialSort;

        return $this;
    }

    public function getColumnHeaderSortMulti(): ?bool
    {
        return $this->columnHeaderSortMulti;
    }

    /**
     * By default, you can sort by multiple columns at the same time by holding the ctrl or shift key
     * when you click on the column headers.
     *
     * If you wish to disable this behaviour, so only once column can be sorted at a time,
     * you can set this option to false
     *
     * @param bool|null $columnHeaderSortMulti
     * @return Table
     */
    public function setColumnHeaderSortMulti(?bool $columnHeaderSortMulti): self
    {
        $this->columnHeaderSortMulti = $columnHeaderSortMulti;

        return $this;
    }

    public function getHeaderSortClickElement(): ?HeaderSortClickElement
    {
        return $this->headerSortClickElement;
    }

    /**
     * By default, header sorting is managed by clicking anywhere on the column header element.
     * If you preferred to restrict this to just the sort icon then you can configure this by setting
     * this option to `HeaderSortClickElement::ICON`:
     *
     * @param HeaderSortClickElement|null $headerSortClickElement
     * @return Table
     */
    public function setHeaderSortClickElement(?HeaderSortClickElement $headerSortClickElement): self
    {
        $this->headerSortClickElement = $headerSortClickElement;

        return $this;
    }

    public function getHeaderSortElement(): ?string
    {
        return $this->headerSortElement;
    }

    /**
     * By default, Tabulator will use a caret arrow to indicate sort direction in a column's header.
     * You can customise the icon used for the column header sort by passing in the HTML for the sorting element
     *
     * @param string|null $headerSortElement
     * @return Table
     */
    public function setHeaderSortElement(?string $headerSortElement): self
    {
        $this->headerSortElement = $headerSortElement;

        return $this;
    }

    public function getFilterMode(): FilterMode
    {
        return $this->filterMode;
    }

    public function setFilterMode(FilterMode $filterMode): self
    {
        $this->filterMode = $filterMode;

        return $this;
    }

    public function getPopupContainer(): string|bool|null
    {
        return $this->popupContainer;
    }

    public function setPopupContainer(string|bool|null $popupContainer): self
    {
        $this->popupContainer = $popupContainer;

        return $this;
    }

    public function getColumnCalcs(): ?CalculationVisibility
    {
        return $this->columnCalcs;
    }

    /**
     * By default, column calculations are shown at the top and bottom of the table, unless row grouping is enabled,
     * in which case they are shown at the top and bottom of each group.
     *
     * @param CalculationVisibility|null $columnCalcs
     * @return Table
     */
    public function setColumnCalcs(?CalculationVisibility $columnCalcs): self
    {
        $this->columnCalcs = $columnCalcs;

        return $this;
    }

    public function isGroupClosedShowCalcs(): bool
    {
        return $this->groupClosedShowCalcs;
    }

    /**
     * By default, Tabulator will hide column calculations in groups when the group is toggled closed.
     * If you would like column calculations to display when a group is closed,
     * set the groupClosedShowCalcs option to true.
     *
     * @param bool $groupClosedShowCalcs
     * @return Table
     */
    public function setGroupClosedShowCalcs(bool $groupClosedShowCalcs): self
    {
        $this->groupClosedShowCalcs = $groupClosedShowCalcs;

        return $this;
    }

    public function isDataTreeChildColumnCalcs(): bool
    {
        return $this->dataTreeChildColumnCalcs;
    }

    /**
     * When you are using the dataTree option with your table, the column calculations will by default only use
     * the data for the top level rows and will ignore any children.
     *
     * @param bool $dataTreeChildColumnCalcs
     * @return Table
     */
    public function setDataTreeChildColumnCalcs(bool $dataTreeChildColumnCalcs): self
    {
        $this->dataTreeChildColumnCalcs = $dataTreeChildColumnCalcs;

        return $this;
    }
}
