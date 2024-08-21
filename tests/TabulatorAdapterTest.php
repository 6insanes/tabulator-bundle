<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Tests;

use DeviantLab\TabulatorBundle\Ajax;
use DeviantLab\TabulatorBundle\Column;
use DeviantLab\TabulatorBundle\Editor\InputEditor;
use DeviantLab\TabulatorBundle\FilterMode;
use DeviantLab\TabulatorBundle\Formatter\RowSelectionFormatter;
use DeviantLab\TabulatorBundle\HozAlign;
use DeviantLab\TabulatorBundle\Layout;
use DeviantLab\TabulatorBundle\Pagination;
use DeviantLab\TabulatorBundle\RowHeader;
use DeviantLab\TabulatorBundle\Table;
use DeviantLab\TabulatorBundle\TabulatorAdapter;
use PHPUnit\Framework\TestCase;

final class TabulatorAdapterTest extends TestCase
{
    public function testLayout(): void
    {
        $table = new Table();
        $adapter = new TabulatorAdapter($table);
        $options = $adapter->getOptions();
        $this->assertArrayNotHasKey('height', $options);

        $table = new Table();
        $table->setLayout(Layout::FIT_COLUMNS);
        $table->setHeight('100%');
        $table->setMaxHeight('99%');
        $table->setMinHeight('98%');
        $adapter = new TabulatorAdapter($table);
        $options = $adapter->getOptions();

        $this->assertArrayHasKey('layout', $options);
        $this->assertSame('fitColumns', $options['layout']);
        $this->assertArrayHasKey('height', $options);
        $this->assertSame('100%', $options['height']);
        $this->assertArrayHasKey('maxHeight', $options);
        $this->assertSame('99%', $options['maxHeight']);
        $this->assertArrayHasKey('minHeight', $options);
        $this->assertSame('98%', $options['minHeight']);

        $this->assertArrayNotHasKey('rowHeight', $options);
    }

    public function testFilterMode(): void
    {
        $table = new Table();
        $adapter = new TabulatorAdapter($table);
        $options = $adapter->getOptions();
        $this->assertSame('local', $options['filterMode']);

        $table = new Table();
        $table->setFilterMode(FilterMode::LOCAL);
        $adapter = new TabulatorAdapter($table);
        $options = $adapter->getOptions();
        $this->assertArrayHasKey('filterMode', $options);
        $this->assertSame('local', $options['filterMode']);

        $table = new Table();
        $table->setFilterMode(FilterMode::REMOTE);
        $adapter = new TabulatorAdapter($table);
        $options = $adapter->getOptions();
        $this->assertArrayHasKey('filterMode', $options);
        $this->assertSame('remote', $options['filterMode']);
    }

    public function testLayoutWithPixels(): void
    {
        $table = new Table(rowHeight: 40);
        $table->setHeight(100);
        $table->setMaxHeight(99);
        $table->setMinHeight(98);
        $adapter = new TabulatorAdapter($table);
        $options = $adapter->getOptions();
        $this->assertArrayHasKey('height', $options);
        $this->assertArrayHasKey('maxHeight', $options);
        $this->assertArrayHasKey('minHeight', $options);
        $this->assertArrayHasKey('rowHeight', $options);
        $this->assertSame(100, $options['height']);
        $this->assertSame(99, $options['maxHeight']);
        $this->assertSame(98, $options['minHeight']);
        $this->assertSame(40, $options['rowHeight']);
    }

    public function testSimpleAjaxConfig(): void
    {
        $ajax = new Ajax(url: 'http://www.getmydata.com/now');
        $table = new Table(ajax: $ajax);
        $adapter = new TabulatorAdapter($table);

        $options = $adapter->getOptions();

        $this->assertArrayHasKey('ajaxURL', $options);
        $this->assertSame('http://www.getmydata.com/now', $options['ajaxURL']);
        $this->assertArrayNotHasKey('ajaxParams', $options);
        $this->assertArrayNotHasKey('ajaxConfig', $options);
        $this->assertArrayNotHasKey('ajaxContentType', $options);
    }

    public function testAjaxConfigWithParams(): void
    {
        $ajax = new Ajax(
            url: 'http://www.getmydata.com/now',
            params: ['key1' => 'value1', 'key2' => 'value2']
        );
        $table = new Table(ajax: $ajax);
        $adapter = new TabulatorAdapter($table);

        $options = $adapter->getOptions();

        $this->assertArrayHasKey('ajaxURL', $options);
        $this->assertArrayHasKey('ajaxParams', $options);
        $this->assertSame('http://www.getmydata.com/now', $options['ajaxURL']);
        $this->assertEquals(['key1' => 'value1', 'key2' => 'value2'], $options['ajaxParams']);
        $this->assertArrayNotHasKey('ajaxConfig', $options);
        $this->assertArrayNotHasKey('ajaxContentType', $options);
    }

    public function testAjaxConfigWithRequestMethod(): void
    {
        $ajax = new Ajax(
            url: 'http://www.getmydata.com/now',
            method: 'POST',
        );
        $ajax->addHeader('Content-type', 'application/json; charset=utf-8');
        $table = new Table(ajax: $ajax);
        $adapter = new TabulatorAdapter($table);

        $options = $adapter->getOptions();

        $this->assertArrayHasKey('ajaxURL', $options);
        $this->assertSame('http://www.getmydata.com/now', $options['ajaxURL']);
        $this->assertArrayHasKey('ajaxConfig', $options);
        $this->assertEquals([
            'method' => 'POST',
            'headers' => [
                'Content-type' => 'application/json; charset=utf-8',
            ],
        ], $options['ajaxConfig']);
        $this->assertArrayNotHasKey('ajaxParams', $options);
        $this->assertArrayNotHasKey('ajaxContentType', $options);
    }

    public function testAjaxConfigWithHeadersButWithoutMethod(): void
    {
        $ajax = new Ajax(
            url: 'http://www.getmydata.com/now',
        );
        $ajax->addHeader('Content-type', 'application/json; charset=utf-8');
        $table = new Table(ajax: $ajax);
        $adapter = new TabulatorAdapter($table);

        $options = $adapter->getOptions();

        $this->assertArrayHasKey('ajaxURL', $options);
        $this->assertSame('http://www.getmydata.com/now', $options['ajaxURL']);
        $this->assertArrayHasKey('ajaxConfig', $options);
        $this->assertEquals([
            'headers' => [
                'Content-type' => 'application/json; charset=utf-8',
            ],
        ], $options['ajaxConfig']);
        $this->assertArrayNotHasKey('ajaxParams', $options);
        $this->assertArrayNotHasKey('ajaxContentType', $options);
    }

    public function testAjaxConfigWithContentType(): void
    {
        $ajax = new Ajax(
            url: 'http://www.getmydata.com/now',
            contentType: 'json'
        );
        $table = new Table(ajax: $ajax);
        $adapter = new TabulatorAdapter($table);

        $options = $adapter->getOptions();

        $this->assertArrayHasKey('ajaxURL', $options);
        $this->assertSame('http://www.getmydata.com/now', $options['ajaxURL']);
        $this->assertArrayHasKey('ajaxContentType', $options);
        $this->assertSame('json', $options['ajaxContentType']);
        $this->assertArrayNotHasKey('ajaxParams', $options);
        $this->assertArrayNotHasKey('ajaxConfig', $options);
    }

    public function testPaginationConfig(): void
    {
        $pagination = new Pagination(
            initialPage: 2,
            pageParamName: 'pageNo',
            sizeParamName: 'sizeNo',
        );
        $table = new Table(pagination: $pagination);
        $adapter = new TabulatorAdapter($table);

        $options = $adapter->getOptions();

        $this->assertSame(true, $options['pagination']);
        $this->assertSame('local', $options['paginationMode']);
        $this->assertSame(2, $options['paginationInitialPage']);
        $this->assertEquals(['page' => 'pageNo', 'size' => 'sizeNo',], $options['dataSendParams']);
    }

    public function testPaginationConfigWithSize(): void
    {
        $pagination = new Pagination(size: 40);
        $table = new Table(pagination: $pagination);
        $adapter = new TabulatorAdapter($table);

        $options = $adapter->getOptions();

        $this->assertSame(true, $options['pagination']);
        $this->assertSame('local', $options['paginationMode']);
        $this->assertSame(40, $options['paginationSize']);
        $this->assertArrayNotHasKey('dataSendParams', $options);
        $this->assertArrayNotHasKey('initialPage', $options);
    }

    public function testPaginationConfigWithCustomParameterName(): void
    {
        $pagination = new Pagination(pageParamName: 'pageNo');
        $table = new Table(pagination: $pagination);
        $adapter = new TabulatorAdapter($table);

        $options = $adapter->getOptions();

        $this->assertSame(true, $options['pagination']);
        $this->assertSame(['page' => 'pageNo',], $options['dataSendParams']);
    }

    public function testColumnOptions(): void
    {
        $table = new Table();
        $table->addColumn(new Column('Name', 'name', width: 100));
        $table->addColumn(new Column('Age', 'age', width: 200, widthShrink: 2, maxWidth: 300, frozen: true, headerSort: true, headerHozAlign: HozAlign::LEFT));
        $table->addColumn(new Column('Color', 'color', widthGrow: 3, minWidth: 100, frozen: false, headerSort: false));
        $adapter = new TabulatorAdapter($table);

        $options = $adapter->getOptions();

        $this->assertEquals([ 'title' => 'Name', 'field' => 'name', 'width' => 100,], $options['columns'][0]);
        $this->assertEquals([ 'title' => 'Age', 'field' => 'age', 'width' => 200, 'widthShrink' => 2, 'maxWidth' => 300, 'frozen' => true, 'headerSort' => true, 'headerHozAlign' => 'left'], $options['columns'][1]);
        $this->assertEquals([ 'title' => 'Color', 'field' => 'color', 'widthGrow' => 3, 'minWidth' => 100, 'frozen' => false, 'headerSort' => false], $options['columns'][2]);
        $this->assertArrayNotHasKey('visible', $options['columns'][0]);
        $this->assertArrayNotHasKey('frozen', $options['columns'][0]);
        $this->assertArrayNotHasKey('minWidth', $options['columns'][0]);
        $this->assertArrayNotHasKey('minWidth', $options['columns'][0]);
        $this->assertArrayNotHasKey('headerSort', $options['columns'][0]);
        $this->assertArrayNotHasKey('headerHozAlign', $options['columns'][0]);
        $this->assertArrayNotHasKey('minWidth', $options['columns'][1]);
        $this->assertArrayNotHasKey('maxWidth', $options['columns'][2]);
    }

    public function testColumnEditor(): void
    {
        $table = new Table();
        $table->addColumn(new Column('Name', 'name'));
        $table->addColumn(new Column('Age', 'age', editor: new InputEditor()));
        $table->addColumn(new Column('Color', 'color'));
        $adapter = new TabulatorAdapter($table);

        $options = $adapter->getOptions();

        $this->assertEquals([ 'title' => 'Name', 'field' => 'name'], $options['columns'][0]);
        $this->assertEquals([ 'title' => 'Age', 'field' => 'age', 'editor' => 'input'], $options['columns'][1]);
        $this->assertEquals([ 'title' => 'Color', 'field' => 'color'], $options['columns'][2]);
        $this->assertArrayNotHasKey('editor', $options['columns'][0]);
    }

    public function testLayoutColumnsOnNewData(): void
    {
        $table = new Table(layoutColumnsOnNewData: true);
        $adapter = new TabulatorAdapter($table);

        $options = $adapter->getOptions();

        $this->assertSame(true, $options['layoutColumnsOnNewData']);
    }

    public function testAutoResize(): void
    {
        $table = new Table(autoResize: false);
        $adapter = new TabulatorAdapter($table);

        $options = $adapter->getOptions();

        $this->assertSame(false, $options['autoResize']);
    }

    public function testResizableColumnFit(): void
    {
        $table = new Table(resizableColumnFit: false);
        $adapter = new TabulatorAdapter($table);

        $options = $adapter->getOptions();

        $this->assertSame(false, $options['resizableColumnFit']);
    }

    public function testColumnsResize(): void
    {
        $table = new Table();
        $table->addColumn(new Column('Name', 'name'));
        $table->addColumn(new Column('Age', 'age', resizable: true));
        $table->addColumn(new Column('Color', 'color', resizable: false));
        $adapter = new TabulatorAdapter($table);

        $options = $adapter->getOptions();

        $this->assertEquals([ 'title' => 'Name', 'field' => 'name'], $options['columns'][0]);
        $this->assertEquals([ 'title' => 'Age', 'field' => 'age', 'resizable' => true], $options['columns'][1]);
        $this->assertEquals([ 'title' => 'Color', 'field' => 'color', 'resizable' => false], $options['columns'][2]);
        $this->assertArrayNotHasKey('resizable', $options['columns'][0]);
    }

    public function testRowHeader(): void
    {
        $table = new Table(rowHeader: new RowHeader(frozen: true, resizable: false, formatter: new RowSelectionFormatter()));
        $adapter = new TabulatorAdapter($table);
        $options = $adapter->getOptions();

        $this->assertEquals([
            'resizable' => false,
            'frozen' => true,
            'formatter' => 'rowSelection'
        ], $options['rowHeader']);
    }

    public function testRowSelectionFormatter(): void
    {
        $table = new Table(
            selectableRows: true,
        );
        $table->addColumn(new Column(
            hozAlign: HozAlign::CENTER,
            formatter: new RowSelectionFormatter(),
        ));
        $adapter = new TabulatorAdapter($table);
        $options = $adapter->getOptions();

        $this->assertSame(true, $options['selectableRows']);
        $this->assertEquals(['formatter' => 'rowSelection', 'hozAlign' => 'center'], $options['columns'][0]);
        $this->assertArrayNotHasKey('headerFilter', $options['columns'][0]);
        $this->assertArrayNotHasKey('field', $options['columns'][0]);
        $this->assertArrayNotHasKey('title', $options['columns'][0]);
    }
}
