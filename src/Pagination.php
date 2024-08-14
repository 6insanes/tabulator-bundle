<?php

declare(strict_types=1);


namespace DeviantLab\TabulatorBundle;

final class Pagination
{
    public function __construct(
        private readonly PaginationMode $mode = PaginationMode::LOCAL,
        private readonly int            $size = 30,
        private readonly ?int           $initialPage = null,
        private readonly string         $pageParamName = 'page',
        private readonly string         $sizeParamName = 'size',
        private readonly ?array         $sizeSelector = null,
        private readonly ?string        $counter = null,
    )
    {
        if ($size <= 0) {
            throw new \InvalidArgumentException('Size should be greater than 0');
        }

        if ($pageParamName === '') {
            throw new \InvalidArgumentException('pageParamName should not be empty');
        }

        if ($this->sizeParamName === '') {
            throw new \InvalidArgumentException('sizeParamName should not be empty');
        }
    }

    public function validate(Table $table): void
    {
        if ($this->mode === PaginationMode::REMOTE && !$table->getAjax()) {
            throw new \LogicException('Remote pagination cannot be added to table without ajaxUrl');
        }
    }

    public function getMode(): PaginationMode
    {
        return $this->mode;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getInitialPage(): ?int
    {
        return $this->initialPage;
    }

    public function getPageParamName(): string
    {
        return $this->pageParamName;
    }

    public function getSizeParamName(): string
    {
        return $this->sizeParamName;
    }

    public function getSizeSelector(): ?array
    {
        return $this->sizeSelector;
    }

    public function getCounter(): ?string
    {
        return $this->counter;
    }
}
