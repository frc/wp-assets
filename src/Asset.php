<?php

namespace Frc\WP\Assets;

class Asset
{
    protected $manifest;

    protected $path;

    public function __construct($path, $manifest)
    {
        $this->path = ltrim($path, '/');
        $this->manifest = $manifest;
    }

    public function __toString()
    {
        return $this->uri();
    }

    public function versioned()
    {
        return $this->manifest[$this->path] ?? $this->path;
    }

    public function uri()
    {
        return rtrim($this->manifest->uri(), '/') . '/' . ltrim($this->versioned(), '/');
    }

    public function path()
    {
        $path = rtrim($this->manifest->path(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . ltrim($this->versioned(), DIRECTORY_SEPARATOR);
        // Remove query string from path
        return strtok($path, '?');
    }

    public function exists()
    {
        return file_exists($this->path());
    }

    public function notExists()
    {
        return ! $this->exists();
    }

    public function contents()
    {
        if ($this->exists()) {
            return file_get_contents($this->path());
        }
    }
}
