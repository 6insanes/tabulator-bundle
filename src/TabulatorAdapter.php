<?php

declare(strict_types=1);


namespace DeviantLab\TabulatorBundle;

use DeviantLab\TabulatorBundle\Validator\ValidatorInterface;
use DeviantLab\TabulatorBundle\Validator\ValidatorWithParameter;

final class TabulatorAdapter
{
    public function __construct(
        private readonly Table $table,
    )
    {

    }

    public function getOptions(): array
    {
        $result = [
            'placeholder' => $this->table->getPlaceholder(),
            'columns' => [],
        ];

        $result['locale'] = $this->table->getLocale();

        if ($layout = $this->table->getLayout()) {
            $result['layout'] = $layout->value;
        }

        if ($printHeader = $this->table->getPrintHeader()) {
            $result['printHeader'] = $printHeader;
        }

        if ($filterMode = $this->table->getFilterMode()) {
            $result['filterMode'] = $filterMode->value;
        }

        if ($height = $this->table->getHeight()) {
            $result['height'] = $height;
        }

        if ($minHeight = $this->table->getMinHeight()) {
            $result['minHeight'] = $minHeight;
        }

        if ($maxHeight = $this->table->getMaxHeight()) {
            $result['maxHeight'] = $maxHeight;
        }

        if ($rowHeight = $this->table->getRowHeight()) {
            $result['rowHeight'] = $rowHeight;
        }

        if ($layoutColumnsOnNewData = $this->table->getLayoutColumnsOnNewData()) {
            $result['layoutColumnsOnNewData'] = $layoutColumnsOnNewData;
        }

        if (($autoResize = $this->table->getAutoResize()) !== null) {
            $result['autoResize'] = $autoResize;
        }

        if (($resizableColumnFit = $this->table->getResizableColumnFit()) !== null) {
            $result['resizableColumnFit'] = $resizableColumnFit;
        }

        if (($selectableRows = $this->table->getSelectableRows() !== null)) {
            $result['selectableRows'] = $selectableRows;
        }

        if (($data = $this->table->getData()) !== null) {
            $result['data'] = $data;
        }

        if ($ajax = $this->table->getAjax()) {
            $result['ajaxURL'] = $ajax->getUrl();
            if ($params = $ajax->getParams()) {
                $result['ajaxParams'] = $params;
            }
            if ($method = $ajax->getMethod()) {
                $result['ajaxConfig'] = [
                    'method' => $method,
                ];
            }
            if ($headers = $ajax->getHeaders()) {
                $result['ajaxConfig'] ??= [];
                $result['ajaxConfig']['headers'] = $headers;
            }
            if ($contentType = $ajax->getContentType()) {
                $result['ajaxContentType'] = $contentType;
            }
        }

        if ($pagination = $this->table->getPagination()) {
            $result['pagination'] = true;
            $result['paginationMode'] = $pagination->getMode()->value;
            $result['paginationSize'] = $pagination->getSize();
            $result['paginationSizeSelector'] = $pagination->getSizeSelector();

            if ($initialPage = $pagination->getInitialPage()) {
                $result['paginationInitialPage'] = $initialPage;
            }

            if (($pageParamName = $pagination->getPageParamName()) !== 'page') {
                $result['dataSendParams'] = [
                    'page' => $pageParamName,
                ];
            }
            if (($sizeParamName = $pagination->getSizeParamName()) !== 'size') {
                $result['dataSendParams'] ??= [];
                $result['dataSendParams']['size'] = $sizeParamName;
            }
        }

        if ($rowHeader = $this->table->getRowHeader()) {
            if ($rowHeader->resizable !== null) {
                $result['rowHeader'] ??= [];
                $result['rowHeader']['resizable'] = $rowHeader->resizable;
            }

            if ($rowHeader->frozen !== null) {
                $result['rowHeader'] ??= [];
                $result['rowHeader']['frozen'] = $rowHeader->frozen;
            }

            if ($rowHeader->formatter !== null) {
                $result['rowHeader'] ??= [];
                $result['rowHeader']['formatter'] = $rowHeader->formatter->getName();
                $params = $rowHeader->formatter->getParams();
                if (\count($params) > 0) {
                    $result['rowHeader']['formatterParams'] = $params;
                }
            }

            if ($rowHeader->headerSort !== null) {
                $result['rowHeader'] ??= [];
                $result['rowHeader']['headerSort'] = $rowHeader->headerSort;
            }

            if ($rowHeader->hozAlign) {
                $result['rowHeader'] ??= [];
                $result['rowHeader']['hozAlign'] = $rowHeader->hozAlign->value;
            }

            if ($rowHeader->vertAlign) {
                $result['rowHeader'] ??= [];
                $result['rowHeader']['vertAlign'] = $rowHeader->vertAlign->value;
            }
        }

        foreach ($this->table->getColumns() as $column) {
            $item = [];

            if ($column->headerFilter !== null) {
                $item['headerFilter'] = $column->headerFilter;
            }

            if ($column->print !== null) {
                $item['print'] = $column->print;
            }

            if ($column->headerSort !== null) {
                $item['headerSort'] = $column->headerSort;
            }

            if ($column->headerHozAlign !== null) {
                $item['headerHozAlign'] = $column->headerHozAlign->value;
            }

            if ($column->title !== null) {
                $item['title'] = $column->title;
            }

            if ($column->field) {
                $item['field'] = $column->field;
            }

            if ($column->visible !== null) {
                $item['visible'] = $column->visible;
            }

            if ($column->width) {
                $item['width'] = $column->width;
            }

            if ($column->widthGrow) {
                $item['widthGrow'] = $column->widthGrow;
            }

            if ($column->widthShrink) {
                $item['widthShrink'] = $column->widthShrink;
            }

            if ($column->resizable !== null) {
                $item['resizable'] = $column->resizable;
            }

            if ($column->minWidth !== null) {
                $item['minWidth'] = $column->minWidth;
            }

            if ($column->maxWidth !== null) {
                $item['maxWidth'] = $column->maxWidth;
            }

            if ($column->frozen !== null) {
                $item['frozen'] = $column->frozen;
            }

            if ($column->hozAlign) {
                $item['hozAlign'] = $column->hozAlign->value;
            }

            if ($column->vertAlign) {
                $item['vertAlign'] = $column->vertAlign->value;
            }

            if ($mutator = $column->mutator) {
                $item['mutator'] = $mutator->getName();
            }

            if ($accessor = $column->accessor) {
                $item['accessor'] = $accessor->getName();
            }

            if ($formatter = $column->formatter) {
                $item['formatter'] = $formatter->getName();

                $params = $formatter->getParams();
                if (\count($params) > 0) {
                    $item['formatterParams'] = $params;
                }
            }

            if ($editor = $column->editor) {
                $item['editor'] = $editor->getName();
            }

            if ($validator = $column->validator) {
                $item['validator'] = $this->processValidators($validator);
            }

            $result['columns'][] = $item;
        }

        if ($triggerEvent = $this->table->getEditTriggerEvent()) {
            $result['editTriggerEvent'] = $triggerEvent;
        }

        return $result;
    }

    /**
     * @param ValidatorInterface|ValidatorInterface[] $validator
     * @return string|array
     */
    private function processValidators(ValidatorInterface|array $validator): string|array
    {
        if (!is_array($validator)) {
            return $this->getValidatorConfig($validator);
        }

        return array_map(fn(ValidatorInterface $v) => $this->getValidatorConfig($v), $validator);
    }

    private function getValidatorConfig(ValidatorInterface $validator): string|array
    {
        if ($validator instanceof ValidatorWithParameter) {
            return [
                'type' => $validator->getName(),
                'parameters' => $validator->getParameter(),
            ];
        }

        return $validator->getName();
    }
}
