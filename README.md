# WP Assets

This is a must-use plugin used via composer, plugin activation not required.

## Usage

Call function `frc_asset($file)`. For example: 

`wp_enqueue_style('styles', frc_asset('styles/main.css'));`

Available methods: 
* `frc_asset($file)->uri()`
* `frc_asset($file)->path()`
* `frc_asset($file)->exists()`
* `frc_asset($file)->notExists()`
* `frc_asset($file)->contents()`

Casting `frc_asset($file)` to a string will return asset's URI.  

Optional configuration using `add_theme_support` function.

```php
add_theme_support('frc-assets', [
    'root' => 'asset', // Root folder name for distributed assets
    'file' => 'assets.json', // Assetmanifest's file name
    'path' => get_theme_file_path('<root>'), // Full path to root folder
    'uri' => get_theme_file_uri("<roo>"), // Full URI to root folder
    'manifest' => '<path>/<file>', // Full path to manifest file
]);
```
