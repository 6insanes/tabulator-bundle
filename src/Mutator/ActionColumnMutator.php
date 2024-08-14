<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Mutator;


use DeviantLab\TabulatorBundle\MutatorInterface;

final class ActionColumnMutator implements MutatorInterface
{
    public function getName(): string
    {
        return 'action';
    }
}
