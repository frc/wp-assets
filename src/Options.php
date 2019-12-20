<?php

namespace Frc\WP\Assets;

class Options
{
    public function get($key, $default = '')
    {
        $feature = get_theme_support('frc-assets');

        if (isset($feature[0][$key])) {
            return $feature[0][$key];
        }
        return $default;
    }
}
