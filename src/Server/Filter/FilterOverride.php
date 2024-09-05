<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Server\Filter;


use DeviantLab\TabulatorBundle\FilterFunction;

final class FilterOverride
{
    private array $overrides = [];

    public function add(string $field, FilterFunction $filterFunction, callable $function): self
    {
        if (!isset($this->overrides[$field])) {
            $this->overrides[$field] = [];
        }

        $this->overrides[$field][$filterFunction->value] = $function;

        return $this;
    }

    public function get(string $field, FilterFunction $filterFunction): ?callable
    {
        return $this->overrides[$field][$filterFunction->value] ?? null;
    }
}
