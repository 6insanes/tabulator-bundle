<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle;

interface OrmTableInterface
{
    public static function getName(): string;

    public function getEntityClass(): string;

    /**
     * @return iterable<Column>
     */
    public function getColumns(): iterable;

    public function load(\Doctrine\Persistence\ObjectRepository $repo);
}
