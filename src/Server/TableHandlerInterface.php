<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Server;

use DeviantLab\TabulatorBundle\TableInterface;
use Symfony\Component\HttpFoundation\Request;

interface TableHandlerInterface
{
    public function supports(TableInterface $tableType): bool;

    public function handle(TableInterface $tableType, Request $request): array;
}
