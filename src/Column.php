<?php

declare(strict_types=1);


namespace DeviantLab\TabulatorBundle;

use DeviantLab\TabulatorBundle\ColumnCalculation\ColumnCalculationInterface;
use DeviantLab\TabulatorBundle\Sorter\SorterInterface;
use DeviantLab\TabulatorBundle\Validator\ValidatorInterface;

final class Column
{
    /**
     * @param string|null $title
     * @param string|null $field
     * @param bool|null $visible
     * @param int|null $width
     * @param int|null $widthGrow
     * @param int|null $widthShrink
     * @param bool|null $resizable
     * @param int|null $minWidth
     * @param int|null $maxWidth
     * @param bool|null $frozen
     * @param HeaderFilter|null $headerFilter
     * @param bool|null $print
     *
     * @param bool|null $headerSort
     * By default, all columns in a table are sortable by clicking on the column header.
     * If you want to disable this behaviour, set the headerSort property to false
     *
     * @param HozAlign|null $headerHozAlign
     * @param HozAlign|null $hozAlign
     * @param VertAlign|null $vertAlign
     * @param MutatorInterface|null $mutator
     * @param AccessorInterface|null $accessor
     * @param FormatterInterface|null $formatter
     * @param EditorInterface|null $editor
     * @param ValidatorInterface|array|null $validator
     * @param SorterInterface|null $sorter
     *
     * @param SortDirection|null $headerSortStartingDir
     * By default, Tabulator will sort a column in ascending order when a user first clicks on the column header.
     * The `headerSortStartingDir` property in the column definition can be used to set the starting sort direction
     * when a user clicks on an unsorted column
     *
     * @param ColumnCalculationInterface|null $topCalc
     * Defines a calculation for the top of the column

     * @param FormatterInterface|null $topCalcFormatter

     * @param ColumnCalculationInterface|null $bottomCalc
     * Defines a calculation for the bottom of the column

     * @param FormatterInterface|null $bottomCalcFormatter
     */
    public function __construct(
        public readonly ?string                       $title = null,
        public readonly ?string                       $field = null,
        public readonly ?bool                         $visible = null,
        public readonly ?int                          $width = null,
        public readonly ?int                          $widthGrow = null,
        public readonly ?int                          $widthShrink = null,
        public readonly ?bool                         $resizable = null,
        public readonly ?int                          $minWidth = null,
        public readonly ?int                          $maxWidth = null,
        public readonly ?bool                         $frozen = null,
        public readonly ?HeaderFilter                 $headerFilter = null,
        public readonly ?bool                         $print = null,
        public readonly ?bool                         $headerSort = null,
        public readonly ?HozAlign                     $headerHozAlign = null,
        public readonly ?HozAlign                     $hozAlign = null,
        public readonly ?VertAlign                    $vertAlign = null,
        public readonly ?MutatorInterface             $mutator = null,
        public readonly ?AccessorInterface            $accessor = null,
        public readonly ?FormatterInterface           $formatter = null,
        public readonly ?EditorInterface              $editor = null,
        /**
         * @var ValidatorInterface|ValidatorInterface[]|null
         */
        public readonly ValidatorInterface|array|null $validator = null,
        public readonly ?SorterInterface              $sorter = null,
        public readonly ?SortDirection                $headerSortStartingDir = null,
        public readonly ?ColumnCalculationInterface   $topCalc = null,
        public readonly ?FormatterInterface           $topCalcFormatter = null,
        public readonly ?ColumnCalculationInterface   $bottomCalc = null,
        public readonly ?FormatterInterface           $bottomCalcFormatter = null,
    )
    {

    }
}
