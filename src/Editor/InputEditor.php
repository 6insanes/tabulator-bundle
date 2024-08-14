<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Editor;

use DeviantLab\TabulatorBundle\EditorInterface;

final class InputEditor implements EditorInterface
{
    public function getName(): string
    {
        return 'input';
    }
}
