<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Validator;


interface ValidatorWithParameter extends ValidatorInterface
{
    public function getParameter(): mixed;
}
