<?php

declare(strict_types=1);


namespace DeviantLab\TabulatorBundle;

final class Table implements TableInterface
{
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

    private string $placeholder = 'Нет данных';

    private SortMode $sortMode = SortMode::LOCAL;

    private ?Pagination $pagination = null;

    private ?Ajax $ajax;

    public function __construct(
        private readonly ?Layout           $layout = null,
        private ?string                    $printHeader = null,
        private FilterMode                 $filterMode = FilterMode::LOCAL,
        private readonly string|int|null   $height = null,
        private readonly string|int|null   $maxHeight = null,
        private readonly string|int|null   $minHeight = null,
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

    public function getHeight(): string|int|null
    {
        return $this->height;
    }

    public function getMaxHeight(): string|int|null
    {
        return $this->maxHeight;
    }

    public function getMinHeight(): string|int|null
    {
        return $this->minHeight;
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

    public function getFilterMode(): FilterMode
    {
        return $this->filterMode;
    }

    public function setFilterMode(FilterMode $filterMode): self
    {
        $this->filterMode = $filterMode;

        return $this;
    }
}
