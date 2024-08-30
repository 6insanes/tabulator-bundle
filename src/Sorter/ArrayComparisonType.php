<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Sorter;


enum ArrayComparisonType: string
{
    /**
     * Sort arrays by length
     */
    case LENGTH = 'length';

    /**
     * Sort arrays by sum of their value
     */
    case SUM = 'sum';

    /**
     * Sort arrays by maximum value
     */
    case MAX = 'max';

    /**
     * Sort arrays by minimum value
     */
    case MIN = 'min';

    /**
     * Sort arrays by average value of all elements
     */
    case AVG = 'avg';
}
