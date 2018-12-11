# kjBot Framework

kjBot 开发框架

## Framework `composer.json`

```json
{
    "license": "MIT",
    "type": "project",
    "autoload": {
        "psr-4": {
            "kjBot\\SDK\\": "SDK/",
            "kjBot\\Framework\\": "framework/"
            "kjBotModule\\": "modules/"
        },
        "files": ["framework/helpers.php"]
    },
    "require": {
        "php": "^7.2",
        "ext-sqlite3": "^7.2"
    },
    "require-dev": {
    },
    "suggest": {
    },
    "scripts": {
    },
    "config": {
        "sort-packages": true,
        "optimize-autoloader": true
    }
}
```