# Wordpress Post Picker ADD-ON

[![Latest Stable Version](https://poser.pugx.org/amostajo/wordpress-add-on-post-picker/v/stable)](https://packagist.org/packages/amostajo/wordpress-add-on-post-picker)
[![Total Downloads](https://poser.pugx.org/amostajo/wordpress-add-on-post-picker/downloads)](https://packagist.org/packages/amostajo/wordpress-add-on-post-picker)
[![License](https://poser.pugx.org/amostajo/wordpress-add-on-post-picker/license)](https://packagist.org/packages/amostajo/wordpress-add-on-post-picker)

![Wordpress Post Picker add-on](http://s9.postimg.org/4tofc2ikv/wordpress_post_picker_addon.jpg)

Add-on package for [Wordpress MVC](http://www.wordpress-mvc.com) exclusively.

Post Picker is a built-in **modal** that can be used within Wordpress' admin dashboard to pick / select posts.

** THIS WILL CREATE CONFLICT WITH VueJS.

- [Installation](#installation)
    - [Configure in Template](#configure-in-template)
- [Usage](#usage)
    - [Enqueue on Main](#enqueue-on-main)
    - [HTML and JS](#html-and-js)
    - [Rendering](#rendering)
        - [Templates](#templates)
    - [Options](#options)
- [Coding Guidelines](#coding-guidelines)
- [Copyright](#copyright)

## Installation

This package requires [Composer](https://getcomposer.org/).

Add it in your `composer.json` file located on your template's root folder:

```json
"amostajo/wordpress-add-on-post-picker": "2.0.*"
```

Then run

```bash
composer install
```

or

```bash
composer update
```

to download package and dependencies.

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

Create a clickable element, who will call the **Post Picker**:

```html
<a id="post-picker-caller">
    Add Posts
</a>
```

Init **Post Picker**, ala jQuery, with the options wanted:

```javascript
$("#post-picker-caller").postPicker({
    render: false,
    success: function (posts) {
        // YOUR CUSTOM CODE HERE
        // Example:
        $.each(posts, function(index) {
            // Print post in console
            console.log(this);
        });
    } 
});
```

### Rendering

**Post Picker** has a built-in rendering system that will lets you display the results easily.

To do this, you need two things in your HTML.
* **Template**: A template for each of the results to display.
* **Placeholder target**: A target element that will act as placeholder for the results.

Example using the previous sample:

```html
<a id="post-picker-caller">
    Add Posts
</a>

<!-- TARGET PLACEHOLDER -->
<div id="post-picker-placeholder"></div>

<!-- TEMPLATE -->
<div id="post-picker-templateholder">
    <div class="post post-{{ ID }}">
        <img alt="{{ title }}">
        <a href="{{ permalink }}">{{ title }}</a>
        <input type="hidden" value="{{ ID }}">
    </div>
</div>
```

The javascript section should look like this:

```javascript
$("#post-picker-caller").postPicker({
    target: "#post-picker-placeholder",
    templateElement: "#post-picker-templateholder"
});
```

**Post Picker** renders the results by default.

#### Templates

There are 3 ways to set your template.

* **Inside caller** (Default): Your template will be the HTML inside the caller tags. In the example case `#post-picker-caller`.
* **An element**: Same as the previous example.
* **As option**: Pass it as jQuery option.

These are the available **Post** properties for display:

| Property                | Description                            |
| ----------------------- | -------------------------------------- |
| `{{ ID }}`              | Post ID.                               |
| `{{ title }}`           | Post title.                            |
| `{{ slug }}`            | Post name / slug.                      |
| `{{ permalink }}`       | Post permalink.                        |
| `{{ image_id }}`        | Featured image ID.                     |
| `{{ image_url }}`       | Featured image url.                    |
| `{{ thumb_image_url }}` | Featured image thumb url (120x120 px). |
| `{{ post_type }}`       | Post type.                             |
| `{{ post_date }}`       | Post date.                             |
| `{{ excerpt }}`         | Excerpt of 15 words.                   |

### Options

| Option            | Data type | Description                                                                         |
| ----------------- | --------- | ----------------------------------------------------------------------------------- |
| `allowMultiple`   | bool      | Flag that indicates multiple post can be selected or just 1. Default: true          |
| `render`          | bool      | Flag that indicates if plugin should render results. Default: true                  |
| `clearTemplate`   | bool      | Flag that indicates if template should be cleared once plugin starts. Default: true |
| `clearTarget`     | bool      | Flag that indicates if target should be cleared on every selection. Default: true   |
| `target`          | string    | Element that will hold results.                                                     |
| `template`        | string    | HTML template.                                                                      |
| `templateElement` | string    | Element containing the template.                                                    |
| `success`         | function  | Callback function with the selected posts.                                          |

## Coding Guidelines

The coding is a mix between PSR-2 and Wordpress PHP guidelines.

## License

**Post Picker** is free software distributed under the terms of the MIT license.
