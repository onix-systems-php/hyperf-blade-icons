# Inline SVG Icons for Hyperf Blade

Implements [orchidsoftware/blade-icons](https://github.com/orchidsoftware/blade-icons) for Hyperf.

## Installation

To install this package, run the following command in your command line:

```php
$ composer require onix-systems-php/blade-icons
```

## Basic Usage

Publish anonymization config:

```shell script
php bin/hyperf.php vendor:publish onix-systems-php/blade-icons
```

When calling the directory method with the first argument, we pass the prefix to call our icons and the second argument is the directory where they are located.

After that, we can call the component in our blade templates:

```blade
<x-orchid-icon path="fa.home" />
```

If you use one or two sets of icons that do not repeat, then it is not necessary to specify a prefix in the component:

```blade
<x-orchid-icon path="home" />
```

You can also list some attributes that should be applied to your icon:

```blade
<x-orchid-icon 
    path="home" 
    class="icon-big" 
    width="2em" 
    height="2em" />
```

## License

The MIT License (MIT). Please see [License File](license.md) for more information.

