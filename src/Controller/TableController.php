<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Controller;

use DeviantLab\TabulatorBundle\OrmTableInterface;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

final class TableController
{
    public function __construct(
        private readonly ContainerInterface $locator,
        private readonly ManagerRegistry $doctrine,
        private readonly SerializerInterface $serializer,
    )
    {

    }

    public function __invoke(Request $request): Response
    {
        $tableName = $request->attributes->get('_tableName');
        /** @var OrmTableInterface $tableType */
        $tableType = $this->locator->get($tableName);

        $repo = $this->doctrine->getRepository($tableType->getEntityClass());
        $data = $tableType->load($repo);

        $json = $this->serializer->serialize($data, 'json');

        return JsonResponse::fromJsonString($json);
    }
}
