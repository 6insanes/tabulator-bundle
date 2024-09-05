<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle;

enum FilterFunction: string
{
    case EQUAL = '=';

    case NOT_EQUAL = '!=';

    case STARTS_WITH = 'starts';

    case ENDS_WITH = 'ends';

    case GREATER_THEN = '>';

    case LESS_THEN = '<';

    case GREATER_THEN_OR_EQUAL = '>=';

    case LESS_THEN_OR_EQUAL = '<=';

    case IN_ARRAY = 'in';

    case KEYWORDS = 'keywords';

    case LIKE = 'like';

    case REGEX = 'regex';

}
