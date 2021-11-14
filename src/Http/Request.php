<?php
namespace App\Http;

class Request
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function get($key)
    {
        return $this->data[$key];
    }

    public function getAll(): array
    {
        return $this->data;
    }
}
