<?php

declare(strict_types=1);


namespace DeviantLab\TabulatorBundle;
enum Layout: string
{
    case FIT_DATA = 'fitData';

    case FIT_DATA_FILL = 'fitDataFill';

    case FIT_DATA_STRETCH = 'fitDataStretch';

    case FIT_DATA_TABLE = 'fitDataTable';

    case FIT_COLUMNS = 'fitColumns';
}
