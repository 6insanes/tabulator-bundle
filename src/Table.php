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

    /**
     * Ajax data loader
     *
     * @var \Closure|null
     */
    private ?\Closure $dataLoader = null;

    private string $placeholder = 'Нет данных';

    private ?Pagination $pagination = null;

    public function __construct(
        private readonly ?string           $title = null,
        private readonly ?Layout           $layout = null,
        private readonly ?bool             $printAsHtml = null,
        private ?string                    $printHeader = null,
        private readonly ?FilterMode       $filterMode = null,
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
        private readonly ?Ajax             $ajax = null,
        ?Pagination                        $pagination = null,
        private readonly ?RowHeader        $rowHeader = null,
    )
    {
        $this->setPagination($pagination);
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getLayout(): ?Layout
    {
        return $this->layout;
    }

    public function getPrintAsHtml(): ?bool
    {
        if ($this->printAsHtml && !($this->printHeader)) {
            $this->printHeader = '<h1 class="tabulator-print-table__header">' . $this->title . '</h1>';
        }
        return $this->printAsHtml;
    }

    public function getFilterMode(): ?FilterMode
    {
        return $this->filterMode;
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

    public function getDataLoader(): ?\Closure
    {
        return $this->dataLoader;
    }

    public function setDataLoader(?\Closure $dataLoader): void
    {
        $this->dataLoader = $dataLoader;
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

    public function getAjax(): ?Ajax
    {
        return $this->ajax;
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
}
