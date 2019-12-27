<?php

use Frc\WP\Assets\Factory;
use Frc\WP\Assets\Options;

function asset($asset)
{
    static $factory;

    if (empty($factory)) {

        $options = new Options;

        $base = ltrim($options->get('dist', 'assets'), '/');
        $file = ltrim($options->get('file', 'assets.json'), '/');

        $manifest = $options->get('manifest', get_theme_file_path("/$base/$file"));
        $uri = $options->get('uri', get_theme_file_uri("/$base"));
        $path = $options->get('path', get_theme_file_path("/$base"));

        $path = '/' . ltrim($path, '/');

        $factory = Factory::make($manifest, $uri, $path);

    }

    return $factory->asset($asset);
}
