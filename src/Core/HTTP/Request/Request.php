<?php

namespace app\Core\HTTP\Request;

class Request
{

    public function __construct(
        private string $path,
        private string $method,
        private array  $request,
        private array  $query,
        private array  $files,
        private ?array $session)
    {
        $this->method = strtoupper($method);
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getRequest(): array
    {
        return $this->request;
    }

    public function getQuery(): array
    {
        return $this->query;
    }

    public function getQueryParams(string $param)
    {
        return $this->query[$param] ?? null;
    }

    public function getRequestParam(string $param)
    {
        return $this->request[$param] ?? null;
    }

    public function getFiles(): ?array
    {
        return $this->files ?? null;
    }

    public function getFileParam(string $filename, string $param)
    {
        return $this->files[$filename][$param] ?? null;
    }

    /**
     * @return array|null
     */
    public function getSession(string $session): ?array
    {
        return $this->session[$session] ?? null;
    }

    public function getSessionParam(string $session, string $param)
    {
        return $this->session[$session][$param] ?? null;
    }

}