<?php
/**
 * @package Paystack\Traits
 */

namespace Matscode\Paystack\Traits;


trait ResourcePath
{
    private $basePath = '', $path;

    /**
     * Use to set resource base path
     *
     * @param string $basePath
     */
    public function setBasePath(string $basePath): void
    {
        $this->basePath = $this->cleanPath($basePath);
    }

    /**
     * Get resource base path
     *
     * @return string
     */
    public function getBasePath(): string
    {
        return $this->basePath;
    }

    /**
     * Gets the constructed path prepended with the base path
     *
     * @param string $path
     * @return string
     */
    public function makePath(string $path = ''): string
    {
        if($path){
            return $this->basePath . $this->cleanPath($path);
        }

        return $this->basePath;
    }

    /**
     * Trim possible redundant slash and add one at the end
     *
     * @param string $path
     * @return string
     */
    public function cleanPath(string $path): string
    {
        return  trim($path, '/') . '/' ;
    }
}