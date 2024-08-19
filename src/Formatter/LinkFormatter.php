<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Formatter;


use DeviantLab\TabulatorBundle\FormatterInterface;

final class LinkFormatter implements FormatterInterface
{
    public function __construct(
        private readonly ?string $labelField = null,
        private readonly ?string $label = null,
        private readonly ?string $urlPrefix = null,
        private readonly ?string $urlField = null,
        private readonly ?string $url = null,
        private readonly ?string $target = null,
        /**
         * @var string|true|null
         */
        private readonly string|bool|null $download = null,
    )
    {

    }

    public function getName(): string
    {
        return 'link';
    }

    public function getParams(): array
    {
        return \array_filter([
            'label' => $this->label,
            'labelField' => $this->labelField,
            'urlPrefix' => $this->urlPrefix,
            'urlField' => $this->urlField,
            'url' => $this->url,
            'target' => $this->target,
            'download' => $this->download,
        ]);
    }
}
