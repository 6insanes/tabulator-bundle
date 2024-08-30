<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\ColumnCalculation;


enum CalculationVisibility: string
{
    /**
     * Show calcs at top and bottom of the table and show in groups
     */
    case BOTH = 'both';

    /**
     * Show calcs at top and bottom of the table only
     */
    case TABLE = 'table';

    /**
     * Show calcs in groups only
     */
    case GROUP = 'group';
}
