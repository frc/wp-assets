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
    'addHashToFilename' => false, // If using laravel mix you can opt to use the hash from query string in filename and get better caching from cdn's and nginx
]);
```

If using 'addHashToFilename' the manifest file should be in the following format with hash length of 20.
```
{
    "/scripts/main.js": "/scripts/main.js?id=a91004e635bd357e16e6"
}
```

And you should have the following in you nginx.conf this strips the added "hash.a91004e635bd357e16e6" from the filename when a request is made

```
location ~ "^(.+)(hash\.[0-9a-f]{20})\.(js|css|ttf|eot|woff2?|png|jpe?g|gif|svg|ico)$" {
    add_header Cache-Control "public";
    expires 10y;
    try_files $uri $1$3 =404;
    access_log off;
}
```
all of these work..  
/GET /scripts/main.hash.a91004e635bd357e16e6.js => /scripts/main.js  
/GET /scripts/main.a91004e635bd357e16e6.js => /scripts/main.a91004e635bd357e16e6.js  
/GET /scripts/main.hash.js => /scripts/main.hash.js  
/GET /scripts/main.js => /scripts/main.js 
