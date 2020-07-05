# For complex string replace

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jkque/laravel-string-replace.svg?style=flat-square)](https://packagist.org/packages/jkque/laravel-string-replace)
[![Build Status](https://img.shields.io/travis/jkque/laravel-string-replace/master.svg?style=flat-square)](https://travis-ci.org/jkque/laravel-string-replace)
[![Quality Score](https://img.shields.io/scrutinizer/g/jkque/laravel-string-replace.svg?style=flat-square)](https://scrutinizer-ci.com/g/jkque/laravel-string-replace)
[![Total Downloads](https://img.shields.io/packagist/dt/jkque/laravel-string-replace.svg?style=flat-square)](https://packagist.org/packages/jkque/laravel-string-replace)

This package will help you when [str_replace](https://www.php.net/manual/en/function.str-replace.php) gets a little bit messy.


## Introduction
When you see something like this:
``` php
$remove_characters = ['<p>', '</p>', '&#39;', '&#039;', '<h2>', '</h2>', '<strong>', '</strong>', '&nbsp;', '&#63;','@name', '&rsquot;', '&quot;', '@firstname'];
$replace_with = ['', '', "'", "'", '', '', '', '', '', '?', $user->name, "'", '"', $user->first_name];

$message = str_replace($remove_characters, $replace_with, $message);
```

A cleaner way:
``` php
use Jkque\StringReplace\StringReplace;

$message = StringReplace::content($string)
    ->when($user, function ($string) use($user) {
        return $string->with(new UserStringReplace($user));
    })
    ->variables([
        '&#39;' => "'",
        '&#63;' => '?'
    ])
    ->replace();
```

```php
use Jkque\StringReplace\StringReplace;

use App\User;

class UserStringReplace extends StringReplace
{
    public function __construct(User $user)
    {
        $this->variables([
            '@name' => $user->name,
        ]);
    }
}
```
## Usage

```php
use Jkque\StringReplace\StringReplace;

$string = 'We are awesome <p>in php</p> replacethis';

$string = StringReplace::content($string)
    ->variables([
        'replacethis' => 'coding',
    ])
    ->replace(); // the ending method to be called
```

You can use conditional closures `when` and `unless`
```php
$string->when($somecondtion, function ($string) {
 // do something;
})
```
By default html tags is being strip but you can turn it off by passing a false value in `stripTags(false)` method.
### Pipeline
To breakdown complex process into individual tasks you can create a class that extends `Jkque\StringReplace\StringReplace`
```php
use Jkque\StringReplace\StringReplace;

class RemoveBadWords extends StringReplace
{
    public function __construct()
    {
        $this->variables([
            'badword' => '*',
        ]);
    }
}
```
A helper command to create this class `php artisan string-replace:pipe {name} {model? : With model}`. You can change the namespace of your model in the config file the default is 'App\\'.

## Installation
You can install the package via composer:
```bash
composer require jkque/laravel-string-replace
```
publish config files
```bash
php artisan vendor:publish --provider="Jkque\StringReplace\StringReplaceServiceProvider"
```
## Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email johnkevin.cadungog@gmail.com instead of using the issue tracker.

## Credits

- [John Kevin Cadungog](https://github.com/jkque)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.