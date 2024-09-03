<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Editor;


enum VerticalNavigation: string
{
    /**
     * The arrow keys move the cursor around the text area, when the cursor reaches the start or end of the contents
     * of the text area it navigates to the next row of the table (default)
     */
    case HYBRID = 'hybrid';

    /**
     * The arrow keys move the cursor around the textarea contents but do not navigate round the table
     */
    case EDITOR = 'editor';

    /**
     * The arrow keys will navigate to the prev/next row and will not move the cursor in the editor
     */
    case TABLE = 'table';
}
