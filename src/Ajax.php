<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle;

final class Ajax
{
    /**
     * @var array<string, string>
     */
    private array $headers = [];

    public function __construct(
        private readonly string  $url,
        private readonly ?array  $params = null,
        private readonly ?string $method = null,
        private readonly ?string $contentType = null,
    )
    {

    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getParams(): ?array
    {
        return $this->params;
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    public function getContentType(): ?string
    {
        return $this->contentType;
    }

    public function addHeader(string $key, string $value)
    {
        $this->headers[$key] = $value;
    }

    /**
     * @return array<string, string>
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }
}
