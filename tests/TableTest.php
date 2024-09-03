<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Tests;

use DeviantLab\TabulatorBundle\Ajax;
use DeviantLab\TabulatorBundle\Column;
use DeviantLab\TabulatorBundle\Pagination;
use DeviantLab\TabulatorBundle\PaginationMode;
use DeviantLab\TabulatorBundle\Table;
use PHPUnit\Framework\TestCase;

final class TableTest extends TestCase
{
    public function testThatUserCannotAddMultipleIdenticalColumns(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $table = new Table();
        $table->addColumn(new Column('Name', 'name'));
        $table->addColumn(new Column('Name', 'name'));
    }

    public function testThatUserCanAddDuplicateColumnsWithoutField(): void
    {
        $table = new Table();
        $table->addColumn(new Column());
        $table->addColumn(new Column());
        $this->assertCount(2, $table->getColumns());
    }

    public function testThatPaginationCanBeAddedToTable(): void
    {
        $pagination = new Pagination();

        $table =  new Table();
        $table->setPagination($pagination);
        $this->assertSame($pagination, $table->getPagination());
    }

    public function testThatRemotePaginationCannotBeAddedToTableWithoutAjaxModule(): void
    {
        $pagination = new Pagination(PaginationMode::REMOTE);
        $this->expectException(\LogicException::class);
        $table = new Table();
        $table->setPagination($pagination);
    }

    public function testThatRemotePaginationCannotBeAddedViaConstructorToTableWithoutAjaxModule(): void
    {
        $pagination = new Pagination(PaginationMode::REMOTE);
        $this->expectException(\LogicException::class);
        $table = new Table();
        $table->setPagination($pagination);
    }

    public function testThatRemotePaginationCanBeAdded(): void
    {
        $pagination = new Pagination(PaginationMode::REMOTE);
        $ajax = new Ajax('/data');
        $table = new Table();
        $table->setAjax($ajax);
        $table->setPagination($pagination);
        $this->assertInstanceOf(Table::class, $table);
    }
}
