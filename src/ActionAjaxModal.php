<?php

declare(strict_types=1);


namespace DeviantLab\TabulatorBundle;
final class ActionAjaxModal
{
    public function __construct(
        public readonly string  $id,
        public readonly string  $title,
        public readonly ?string $url = null,
        /**
         * Имя свойства в row на фронте, содержащего url
         * Добавляется через TableDataNormalizer
         */
        public readonly ?string $urlProp = null,
    )
    {
        if ($url === null && $urlProp === null) {
            throw new \InvalidArgumentException('url or urlProp should be provided');
        }
    }
}
