<?php

declare(strict_types=1);


namespace DeviantLab\TabulatorBundle;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(name: 'app.table.table_type')]
interface TableTypeInterface
{
    public function build(): Table;
}
