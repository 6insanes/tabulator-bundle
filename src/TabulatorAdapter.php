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
        $result['sortMode'] = $this->table->getSortMode()->value;
        $result['filterMode'] = $this->table->getFilterMode()->value;

        if ($dataTree = $this->table->isDataTree()) {
            $result['dataTree'] = $dataTree;
        }

        if ($dataTreeStartExpanded = $this->table->isDataTreeStartExpanded()) {
            $result['dataTreeStartExpanded'] = $dataTreeStartExpanded;
        }

        if (!$dataTreeFilter = $this->table->isDataTreeFilter()) {
            $result['dataTreeFilter'] = $dataTreeFilter;
        }

        if ($popupContainer = $this->table->getPopupContainer()) {
            $result['popupContainer'] = $popupContainer;
        }

        if (!$dataTreeSort = $this->table->isDataTreeSort()) {
            $result['dataTreeSort'] = $dataTreeSort;
        }

        if ($layout = $this->table->getLayout()) {
            $result['layout'] = $layout->value;
        }

        if ($printHeader = $this->table->getPrintHeader()) {
            $result['printHeader'] = $printHeader;
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

        if ($initialSort = $this->table->getInitialSort()) {
            $result['initialSort'] = iterator_to_array($initialSort);
        }

        if ($initialFilter = $this->table->getInitialFilter()) {
            $result['initialFilter'] = iterator_to_array($initialFilter);
        }

        if ($columnHeaderSortMulti = $this->table->getColumnHeaderSortMulti()) {
            $result['columnHeaderSortMulti'] = $columnHeaderSortMulti;
        }

        if ($headerSortClickElement = $this->table->getHeaderSortClickElement()) {
            $result['headerSortClickElement'] = $headerSortClickElement->value;
        }

        if ($headerSortElement = $this->table->getHeaderSortElement()) {
            $result['headerSortElement'] = $headerSortElement;
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

        if ($columnCalcs = $this->table->getColumnCalcs()) {
            $result['columnCalcs'] = $columnCalcs->value;
        }

        if ($this->table->isGroupClosedShowCalcs()) {
            $result['groupClosedShowCalcs'] = true;
        }

        if ($this->table->isDataTreeChildColumnCalcs()) {
            $result['dataTreeChildColumnCalcs'] = true;
        }

        foreach ($this->table->getColumns() as $column) {
            $item = [];

            if ($column->headerFilter !== null) {
                $item['headerFilter'] = $column->headerFilter->editor->getName();
                $item['headerFilterPlaceholder'] = $column->headerFilter->placeholder;
                $item['headerFilterFunc'] = $column->headerFilter->filterFunction->value;
                $params = [];
                if ($newParams = $column->headerFilter->editor->getParams()) {
                    $params = $newParams;
                }
                if ($column->headerFilter->initial !== HeaderFilter::INITIAL_UNDEFINED) {
                    $params['initial'] = $column->headerFilter->initial;
                }
                if ($params) {
                    $item['headerFilterParams'] = $params;
                }
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
                if ($params = $editor->getParams()) {
                    $item['editorParams'] = $params;
                }
            }

            if ($validator = $column->validator) {
                $item['validator'] = $this->processValidators($validator);
            }

            if ($sorter = $column->sorter) {
                $item['sorter'] = $sorter->getName();
                if ($params = $sorter->getParams()) {
                    $item['sorterParams'] = $params;
                }
            }

            if ($column->headerSortStartingDir) {
                $item['headerSortStartingDir'] = $column->headerSortStartingDir->value;
            }

            if ($column->topCalc) {
                $item['topCalc'] = $column->topCalc->getName();
                if ($params = $column->topCalc->getParams()) {
                    $item['topCalcParams'] = $params;
                }
            }

            if ($column->topCalcFormatter) {
                $item['topCalcFormatter'] = $column->topCalcFormatter->getName();
                if ($params = $column->topCalcFormatter->getParams()) {
                    $item['topCalcFormatterParams'] = $params;
                }
            }

            if ($column->bottomCalc) {
                $item['bottomCalc'] = $column->bottomCalc->getName();
                if ($params = $column->bottomCalc->getParams()) {
                    $item['bottomCalcParams'] = $params;
                }
            }

            if ($column->bottomCalcFormatter) {
                $item['bottomCalcFormatter'] = $column->bottomCalcFormatter->getName();
                if ($params = $column->bottomCalcFormatter->getParams()) {
                    $item['bottomCalcFormatterParams'] = $params;
                }
            }

            $result['columns'][] = $item;
        }

        if ($triggerEvent = $this->table->getEditTriggerEvent()) {
            $result['editTriggerEvent'] = $triggerEvent;
        }

        $dataLoader = $this->table->getDataLoader();
        if ($dataLoader === false) {
            $result['dataLoader'] = false;
        }

        if ($dataLoaderLoading = $this->table->getDataLoaderLoading()) {
            $result['dataLoaderLoading'] = $dataLoaderLoading;
        }

        if ($dataLoaderError = $this->table->getDataLoaderError()) {
            $result['dataLoaderError'] = $dataLoaderError;
        }

        $dataLoaderErrorTimeout = $this->table->getDataLoaderErrorTimeout();
        if ($dataLoaderErrorTimeout !== null) {
            $result['dataLoaderErrorTimeout'] = $this->table->getDataLoaderErrorTimeout();
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
