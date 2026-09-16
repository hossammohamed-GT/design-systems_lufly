<?php

declare(strict_types=1);

namespace Core\Http;

class Response
{
    /** @param array<string, string> $headers */
    public function __construct(
        protected string $content = '',
        protected int $status = 200,
        protected array $headers = [],
    ) {
        if (!isset($this->headers['Content-Type'])) {
            $this->headers['Content-Type'] = 'text/html; charset=utf-8';
        }
    }

    public static function make(string $content = '', int $status = 200, array $headers = []): static
    {
        return new static($content, $status, $headers);
    }

    /** @param array<string|int, mixed> $data */
    public static function json(array $data, int $status = 200, array $headers = []): JsonResponse
    {
        return new JsonResponse($data, $status, $headers);
    }

    /** @param array<string, mixed> $data */
    public static function view(string $template, array $data = [], int $status = 200): Response
    {
        $view = app(\Core\View\View::class);

        return new static($view->render($template, $data), $status);
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function header(string $name, string $value): static
    {
        $this->headers[$name] = $value;
        return $this;
    }

    /** @return array<string, string> */
    public function headers(): array
    {
        return $this->headers;
    }

    public function send(): void
    {
        if (!headers_sent()) {
            http_response_code($this->status);
            foreach ($this->headers as $name => $value) {
                header($name . ': ' . $value);
            }
        }

        echo $this->content;
    }
}
