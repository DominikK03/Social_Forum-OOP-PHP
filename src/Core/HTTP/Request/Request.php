<?php

namespace app\Core\HTTP\Request;

class Request
{
    public function __construct(
        private string $path,
        private string $method,
        private array $request,
        private array $query,
        private array $files,
        private ?array $session
    )
    {
        $this->method = strtoupper($method);
        if ($this->isJsonRequest()) {
            $jsonData = json_decode(file_get_contents("php://input"), true);
            if (is_array($jsonData)) {
                $this->request = array_merge($this->request, $jsonData);
            }
        }
    }

    private function isJsonRequest(): bool
    {
        return isset($_SERVER['CONTENT_TYPE']) && str_contains($_SERVER['CONTENT_TYPE'], 'application/json');
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