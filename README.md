# Laravel Profanity Validator

[![Latest Version on Packagist](https://img.shields.io/packagist/v/envatic/laravel-profane.svg?style=flat-square)](https://packagist.org/packages/envatic/laravel-profane)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![run-tests](https://github.com/envatic/laravel-profane/actions/workflows/run-tests.yml/badge.svg)](https://github.com/envatic/laravel-profane/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/envatic/laravel-profane.svg?style=flat-square)](https://packagist.org/packages/envatic/laravel-profane)
[![Check & fix styling](https://github.com/envatic/laravel-profane/actions/workflows/php-cs-fixer.yml/badge.svg)](https://github.com/envatic/laravel-profane/actions/workflows/php-cs-fixer.yml)

I made this package to perform a validation for swearwords using Laravel validation service.

## Installation

Install via composer

```shell
composer require envatic/laravel-profane
```

## Configuration

Add the `ProfaneServiceProvider` class in your `config/app.php` file.

```php
<?php
return [
    // ...

    'providers' => [
        // ...
        LaravelProfane\ProfaneServiceProvider::class,
    ];

    // ...
];
```

Publish vendor lang files if you need to replace by your own.

```shell
php artisan vendor:publish
```

## Usage

This package register a custom validator. You can use in your controller's `validate` function.

```php
<?php
// ...
class MyController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|profane'
        ]);

        // ...
    }
}
```

The validator will load the default locale in your `config/app.php` file configuration which by is `en`. **If your locale is not supported, please [post an issue for this project](https://github.com/envatic/laravel-profane/issues)**

If you want to use others dictionaries you can pass them as parameters in the validator.

```php
<?php
// ...
class MyController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|profane:es,en'
        ]);

        // ...
    }
}
```

You can also send as parameter a path of a file which is a dictionary in order to replace the default dictionary or **add a new non supported locale**.

```php
<?php
// ...
class MyController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|profane:es,en,'.resource_path('lang/fr/dict.php')
        ]);

        // ...
    }
}
```

#### Strict validation

Now you can strictly validate the exact profane word in the content.

```php
<?php
// ...
class MyController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|strictly_profane:es,en'
        ]);

        // ...
    }
}
```

This fixes known issues when you get a error in validation for words like `class` or `analysis`, as they include `ass` and `anal` respectively, but fails the validation for content like `sucker69`.

## Getting Help

If you're stuck getting something to work, or need to report a bug, please [post an issue in the Github Issues for this project](https://github.com/envatic/laravel-profane/issues).

## Contributing

If you're interesting in contributing code to this project, clone it by running:

```shell
git clone git@github.com:envatic/laravel-profane.git
```

Please read the [CONTRIBUTING](CONTRIBUTING.md) file.

Pull requests are welcome, but please make sure you provide unit tests to cover your changes. **You can help to add and support more locales!**

_Thanks to [@dorianneto](https://github.com/dorianneto) for his contributions._

### Supported Locales

- English ( provided by [@envatic](https://github.com/envatic) )
- Spanish ( provided by [@envatic](https://github.com/envatic) and [@xDidier901](https://github.com/xDidier901))
- Italian ( provided by [@aletundo](https://github.com/aletundo) )
- Brazilian Portuguese ( provided by [@ianrodriguesbr](https://github.com/ianrodriguesbr)  and [@LeonardoTeixeira](https://github.com/LeonardoTeixeira))
- Traditional Chinese ( provided by [@Nationalcat](https://github.com/Nationalcat) )
- Slovak ( provided by [@kotass](https://github.com/kotass) )
- Dutch (Netherlands) ( provided by [@Cannonb4ll](https://github.com/Cannonb4ll) and [@WouterVanmulken](https://github.com/WouterVanmulken))
- Greek ( provided by [@siokas](https://github.com/siokas) )
- Malayalam ( provided by [@abinodh](https://github.com/abinodh) )
- Russian ( provided by [@alex2sat](https://github.com/alex2sat) )
- Serbian ( provided by [@Djuki](https://github.com/Djuki) )
- Filipino ( provided by [@credocleo](https://github.com/credocleo) )
- Romanian ( provided by [@rchioreanu](https://github.com/rchioreanu) )
- Indonesian ( provided by [@rizasaputra](https://github.com/rizasaputra) )

## License

This project is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
