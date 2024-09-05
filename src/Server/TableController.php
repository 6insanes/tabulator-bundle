<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Server;

use DeviantLab\TabulatorBundle\TableInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

final class TableController
{
    public function __construct(
        private readonly ContainerInterface $locator,
        private readonly iterable $tableHandlers,
        private readonly SerializerInterface $serializer,
    )
    {

    }

    public function __invoke(Request $request): Response
    {
        $tableName = $request->attributes->get('_tableName');
        /** @var TableInterface $tableType */
        $tableType = $this->locator->get($tableName);

        foreach ($this->tableHandlers as $handler) {
            /** @var TableHandlerInterface $handler */
            if ($handler->supports($tableType)) {
                $data = $handler->handle($tableType, $request);
            }
        }

        $json = $this->serializer->serialize($data, 'json');
        return JsonResponse::fromJsonString($json);
    }
}
