<?php

namespace App\Http;

class Response
{
    protected string $content;
    protected array $headers;
    protected int $status;

    public function __construct(
        string $content = '',
        array $headers = ['Content-Type' => 'text/html'],
        int $status = 200
    ) {
        $this->content = $content;
        $this->headers = $headers;
        $this->status = $status;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;
        return $this;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function send()
    {
        foreach ($this->headers as $header => $value) {
            header("$header: $value");
        }

        http_response_code($this->status);

        echo $this->content;
    }

    public function redirect(string $path)
    {
        $this->setHeaders(['Location' => $path]);
        $this->setStatus(301);
        $this->setContent('redirection ...');

        $this->send();
    }
}
