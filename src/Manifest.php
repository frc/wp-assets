<?php

namespace Frc\WP\Assets;

use ArrayAccess;

class Manifest implements ArrayAccess
{
    protected $manifest;

    protected $uri;

    protected $path;

    public function __construct($manifest, $uri, $path)
    {
        $this->manifest = file_exists($manifest)
            ? json_decode(file_get_contents($manifest), true)
            : [];

        $this->manifest = $this->normalizeKeys($this->manifest);

        $this->uri = $uri;
        $this->path = $path;
    }

    protected function normalizeKeys($manifest) {
        $items = [];
        foreach($manifest as $key => $value) {
            $key = ltrim($key, '/');
            $items[$key] = $value;
        }
        return $items;
    }

    public function offsetExists($key)
    {
        return isset($this->manifest[$key]);
    }

    public function offsetGet($key)
    {
        return $this->manifest[$key];
    }

    public function offsetSet($key, $value)
    {
        $this->manifest[$key] = $value;
    }

    public function offsetUnset($key)
    {
        unset($this->manifest[$key]);
    }

    public function uri()
    {
        return $this->uri;
    }

    public function path()
    {
        return $this->path;
    }
}
