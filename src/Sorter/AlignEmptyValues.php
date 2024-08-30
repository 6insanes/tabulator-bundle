<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Sorter;

enum AlignEmptyValues: string
{
    /**
     * Force empty cells to the top of the table
     */
    case TOP = 'top';

    /**
     * Force empty cells to the bottom of the table
     */
    case BOTTOM = 'bottom';
}
