<?php

declare(strict_types=1);


namespace DeviantLab\TabulatorBundle;

interface TableTypeInterface
{
    public function build(): Table;
}
