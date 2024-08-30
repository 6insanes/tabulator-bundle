<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle;

enum SortDirection: string
{
    case ASC = 'asc';
    case DESC = 'desc';
}
