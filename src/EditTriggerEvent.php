<?php

declare(strict_types=1);


namespace DeviantLab\TabulatorBundle;
enum EditTriggerEvent: string
{
    case FOCUS = 'focus';

    case CLICK = 'click';

    case DBLCLICK = 'dblclick';
}
