# Laravel SMS Verification

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

## Run the composer command to install

```bash
composer require ferdousanam/laravel-sms-verification
```

Add `mobile_number_verified_at` column to `Authenticatable` model's migration file.

```php
$table->timestamp('mobile_number_verified_at')->nullable();
```

## Publish the migration files

```bash
php artisan vendor:publish --tag=sms-verification-migrations
```

## Scaffold the sms verification controllers

```bash
php artisan sms-verification:controllers
```

## Scaffold the sms verification channels

```bash
php artisan sms-verification:channels
```

## Publish config

Run the following command to publish configuration file
```bash
php artisan vendor:publish --tag=sms-verification
```

## Usage

Use the traits `HasVerificationTokens`, `MustVerifyMobileNumber` in `Authenticatable` models

```php
<?php

namespace App\Models;

use Anam\SmsVerification\Contracts\MustVerifyMobileNumber as MustVerifyMobileNumberContract;
use Anam\SmsVerification\HasVerificationTokens;
use Anam\SmsVerification\MustVerifyMobileNumber;

class User extends Authenticatable
{
    use HasVerificationTokens, MustVerifyMobileNumber;
    
    //...
}
```

## Check available routes for `sms-verification`

```bash
php artisan route:list --name=sms-verification
```

## Dev Instruction
[DEV.md](DEV.md)

## Author

Contact Author if interested for author as author is too lazy to write documentation
🙁 [Ferdous Anam](https://ferdousanam.gitlab.io).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/ferdousanam/laravel-sms-verification?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/ferdousanam/laravel-sms-verification?style=flat-square
[ico-license]: https://img.shields.io/github/license/ferdousanam/laravel-sms-verification?style=flat-square
[link-packagist]: https://packagist.org/packages/ferdousanam/laravel-sms-verification
[link-downloads]: https://packagist.org/packages/ferdousanam/laravel-sms-verification
[link-author]: https://github.com/ferdousanam
