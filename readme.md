# Displore Widgets

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Quality Score][ico-code-quality]][link-code-quality]

Widgets back to basic, with Laravel support.

## Install

### Via [Displore Core][link-displore-core]

``` bash
$ php artisan displore:install widgets
```
This does everything for you, from the Composer requirement to the addition of Laravel service providers.

### Via Composer

``` bash
$ composer require displore/widgets
```
This requires the addition of the Widgets service provider and Widgets facade alias to config/app.php if you use the package with Laravel.
`Displore\Widgets\WidgetsServiceProvider::class,`
and
`Displore\Widgets\Facades\Widget::class,`

### Configuration

In the configuration file you can set up dynamic resolving or register the widgets in a similar fashion to how config/app.php works with aliases.
```bash
$ php artisan vendor:publish --tag=displore.widgets.config
```

## Usage

The package does not rely on Laravel, as shows the following example.
``` php
$arrayOfProviders = [
    'headline'  =>  My\Widgets\Headline::class,
];
$service = new WidgetsProvider($arrayOfProviders);
$widget = $service->get('headline'); // Calls getWidget() on the Headline class.
```

With Laravel, the array of providers is found in a dedicated configuration file. In your views you can call the `Widget` facade to get widgets.

It is also possible, either with or without Laravel, to use a dynamic widgets provider, meaning that on every request, all classes in a given path will be searched for the widget needed. Especially useful during development.
For Laravel, set `dynamic` to true in the configuration file. For non-laravel:
```php
$service = (new DynamicWidgetsProvider)
            ->withPath('Path/To/Widgets/Classes')
            ->withNamespace('My\\Widgets')
            ->scanForProviders();
$widget = $service->get('headline');
```

You can also set widgets during runtime, with both the static and dynamic widgets provider:
```php
// Laravel facade
Widget::set('headline', new My\Widgets\Headline::class);

// Self instantiated service
$service->set('headline', new My\Widgets\Headline::class);
```

## Change log

Please see [changelog](changelog.md) for more information what has changed recently.

## Testing

The package comes with unit tests.
In a Laravel application, with [Laravel Packager](https://github.com/Jeroen-G/laravel-packager):
``` bash
$ php artisan packager:git *Displore Github url*
$ php artisan packager:tests Displore Widgets
$ phpunit
```

## Contributing

Please see [contributing](contributing.md) for details.

## Credits

- [JeroenG][link-author]
- [All Contributors][link-contributors]

## License

The EUPL License. Please see the [License File](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/displore/widgets.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/displore/widgets.svg?style=flat-square

[link-displore-core]: https://github.com/displore/core

[link-packagist]: https://packagist.org/packages/displore/widgets
[link-code-quality]: https://scrutinizer-ci.com/g/displore/widgets
[link-author]: https://github.com/Jeroen-G
[link-contributors]: ../../contributors
