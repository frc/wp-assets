<?php

namespace Frc\WP\Assets;

class Factory
{
    protected $manifest;

    public function __construct($manifest)
    {
        $this->manifest = $manifest;
    }

    public function asset($path)
    {
        return new Asset($path, $this->manifest);
    }

    public static function make($manifest, $uri, $path)
    {
        return new static(
            new Manifest($manifest, $uri, $path)
        );
    }
}
