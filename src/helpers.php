<?php

use Frc\WP\Assets\Factory;
use Frc\WP\Assets\Options;

function frc_asset($asset)
{
    static $factory;
    $options = new Options;

    if (empty($factory)) {

        $root = ltrim($options->get('root', 'assets'), '/');
        $file = ltrim($options->get('file', 'assets.json'), '/');

        $path =  '/' . ltrim($options->get('path', get_theme_file_path("/$root")), '/');
        $manifest = $options->get('manifest', "$path/$file");
        $uri = $options->get('uri', get_theme_file_uri("/$root"));

        $factory = Factory::make($manifest, $uri, $path);
    }

    $addHashToFilename = $options->get('addHashToFilename', false);
    return $factory->asset($asset, $addHashToFilename);
}
