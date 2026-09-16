<?php

declare(strict_types=1);

namespace Core\Http;

final class Route
{
    /** @var string[] */
    public array $middlewares = [];

    /** @var array<string, string> */
    public array $wheres = [];

    /** @var array<string, mixed> */
    public array $meta = [];

    public ?string $name = null;

    public string $namePrefix = '';

    public bool $localized = false;

    public string $localizedKey = '';

    public ?string $compiledPattern = null;

    /**
     * @param string[] $methods
     * @param callable|string|array $handler
     */
    public function __construct(
        public readonly array $methods,
        public readonly string $uri,
        public mixed $handler,
    ) {
    }

    public function name(string $name): self
    {
        $this->name = $this->namePrefix . $name;
        return $this;
    }

    /** @param string|string[] $middlewares */
    public function middleware(string|array $middlewares): self
    {
        $this->middlewares = array_merge($this->middlewares, (array) $middlewares);
        return $this;
    }

    public function where(string $param, string $regex): self
    {
        $this->wheres[$param] = $regex;
        return $this;
    }

    /** @param array<string, mixed> $meta */
    public function meta(array $meta): self
    {
        $this->meta = array_merge($this->meta, $meta);
        return $this;
    }

    /**
     * API documentation metadata consumed by `php cli docs:api`.
     *
     * @param array<string, string> $validationRules
     */
    public function doc(string $summary, array $validationRules = [], array $responseExample = []): self
    {
        $this->meta['doc'] = [
            'summary' => $summary,
            'validation' => $validationRules,
            'response' => $responseExample,
        ];

        return $this;
    }
}
