<?php


namespace Matscode\Paystack\Traits;


trait ResourcePath
{
    private $basePath = '', $path;

    public function setBasePath(string $basePath): void
    {
        $this->basePath = $basePath;
    }

    public function setPath(string $path): void
    {
        $this->path = $this->basePath . $path;
    }

    public function getPath(): string
    {
        return $this->path;
    }
}