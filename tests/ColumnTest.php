<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Tests;

use DeviantLab\TabulatorBundle\Column;
use PHPUnit\Framework\TestCase;

final class ColumnTest extends TestCase
{
    public function testThatColumnObjectCanBeCreated(): void
    {
        $column = new Column('ID', 'id');
        $this->assertInstanceOf(Column::class, $column);
    }
}
