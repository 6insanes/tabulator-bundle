<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Validator;


final class MaxLength implements ValidatorWithParameter
{
    public function __construct(private readonly int $max)
    {

    }

    public function getName(): string
    {
        return 'maxLength';
    }

    public function getParameter(): mixed
    {
        return $this->max;
    }
}
