<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Validator;


final class Required implements ValidatorInterface
{
    public function getName(): string
    {
        return 'required';
    }
}
