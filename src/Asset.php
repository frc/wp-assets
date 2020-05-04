<?php

namespace Frc\WP\Assets;

class Asset
{
    protected $manifest;

    protected $path;

    protected $addHashToFilename;

    public function __construct($path, $manifest, $addHashToFilename)
    {
        $this->path = ltrim($path, '/');
        $this->manifest = $manifest;
        $this->addHashToFilename = $addHashToFilename;
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
        $filename = $this->versioned();
        if ($this->addHashToFilename) {
            $filename = $this->addHashToFilename($filename);
        }

        return rtrim($this->manifest->uri(), '/') . '/' . ltrim($filename, '/');
    }

    public function addHashToFilename($file) {
        $parsed = parse_url($file);
        if (!isset($parsed['query'])) {
            return $file;
        }

        $query = substr($parsed['query'], strrpos($parsed['query'], "=") + 1);
        if (empty($query) || !preg_match('/^[0-9a-f]{20}$/', $query)) {
            return $file;
        }

        $basename = basename($parsed['path']);
        $path     = str_replace($basename, '', $parsed['path']);
        $filename = substr_replace($basename, '.hash.' . $query, strrpos($basename, "."), 0);

        return $path . $filename;
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
