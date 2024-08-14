<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Validator;


final class MinLength implements ValidatorWithParameter
{
    public function __construct(private readonly int $min)
    {

    }

    public function getName(): string
    {
        return 'minLength';
    }

    public function getParameter(): mixed
    {
        return $this->min;
    }
}
