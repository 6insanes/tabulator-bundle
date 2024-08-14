<?php

declare(strict_types=1);


namespace DeviantLab\TabulatorBundle;
enum PaginationMode: string
{
    case LOCAL = 'local';

    case REMOTE = 'remote';
}
