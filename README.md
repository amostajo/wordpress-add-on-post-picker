Wordpress ADD-ON Post Picker
--------------------------------

Add-on package for [Wordpress Plugin Template](https://github.com/amostajo/wordpress-plugin) or [Wordpress Theme Template](https://github.com/amostajo/wordpress-theme) exclusively.

Post Picker is a built-in **modal** that can be used within Wordpress' admin dashboard to pick / select posts.

- [Installation](#installation)
    - [Configure in Template](#configure-in-template)
- [Usage](#usage)
    - [Enqueue on Main](#enqueue-on-main)
    - [HTML and JS](#html-and-js)
- [Coding Guidelines](#coding-guidelines)
- [Copyright](#copyright)

## Installation

This package requires [Composer](https://getcomposer.org/) and [Bower](http://bower.io/) to install its dependencies. Make sure to have these install before proceeding.

Run

```bash
composer install
```

or

```bash
composer update
```

to download dependencies.

### Configure in Template

Add the following string line in your `addons` array option located at your template's config file.

```php
    'Amostajo\Wordpress\PostPickerAddon\PostPicker',
```

This should be added to:
* `config\plugin.php` on Wordpress Plugin Template
* `config\theme.php` on Wordpress Theme Template

## Usage

### Enqueue on Main

Before you do any custom code, you need to load or enqueue the **Post Picker** to Wordpress.

Call `addon_post_picker()` function within your template's Main class, like this:

```php
class Main extends Plugin
{
    public function metabox()
    {
        // The function must be called within your Main.php file
        $this->addon_post_picker();
    }
}
```

### HTML and JS

TODO

## Coding Guidelines

The coding is a mix between PSR-2 and Wordpress PHP guidelines.

## License

**Post Picker** is free software distributed under the terms of the MIT license.
