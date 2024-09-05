<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Server\Sorter;


final class SortOverride
{
    public const DEFAULT = '__DEVIANT_LAB_TABULATOR_BUNDLE_SERVER_SORTER_SORT_OVERRIDE_DEFAULT';

    private array $overrides = [];

    public function add(string $field, callable $function): self
    {
        $this->overrides[$field] = $function;

        return $this;
    }

    public function get(string $field): ?callable
    {
        return $this->overrides[$field] ?? null;
    }
}
