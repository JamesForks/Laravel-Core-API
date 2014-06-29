Laravel Core API
================


[![Build Status](https://img.shields.io/travis/GrahamCampbell/Laravel-Core-API/master.svg?style=flat)](https://travis-ci.org/GrahamCampbell/Laravel-Core-API)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/GrahamCampbell/Laravel-Core-API.svg?style=flat)](https://scrutinizer-ci.com/g/GrahamCampbell/Laravel-Core-API/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/GrahamCampbell/Laravel-Core-API.svg?style=flat)](https://scrutinizer-ci.com/g/GrahamCampbell/Laravel-Core-API)
[![Software License](https://img.shields.io/badge/license-Apache%202.0-brightgreen.svg?style=flat)](LICENSE.md)
[![Latest Version](https://img.shields.io/github/release/GrahamCampbell/Laravel-Core-API.svg?style=flat)](https://github.com/GrahamCampbell/Laravel-Core-API/releases)


## Introduction

Laravel Core API was created by, and is maintained by [Graham Campbell](https://github.com/GrahamCampbell), and provides some core API client functions for [Laravel 4.1+](http://laravel.com). It utilises [Guzzle 4](https://github.com/guzzle/guzzle). Feel free to check out the [change log](CHANGELOG.md), [releases](https://github.com/GrahamCampbell/Laravel-Core-API/releases), [license](LICENSE.md), [api docs](http://grahamcampbell.github.io/Laravel-Core-API), and [contribution guidelines](CONTRIBUTING.md).


## Installation

[PHP](https://php.net) 5.4.7+ or [HHVM](http://hhvm.com) 3.1+, and [Composer](https://getcomposer.org) are required.

To get the latest version of Laravel Core API, simply require `"graham-campbell/core-api": "~0.6"` in your `composer.json` file. You'll then need to run `composer install` or `composer update` to download it and have the autoloader updated.

Once Laravel Core API is installed, you need to register the service provider. Open up `app/config/app.php` and add the following to the `providers` key.

* `'GrahamCampbell\CoreAPI\CoreAPIServiceProvider'`

You can register the CoreAPI facade in the `aliases` key of your `app/config/app.php` file if you like.

* `'CoreAPI' => 'GrahamCampbell\CoreAPI\Facades\CoreAPI'`


## Configuration

Laravel Core API supports optional configuration.

To get started, first publish the package config file:

    php artisan config:publish graham-campbell/core-api

There are two config options:

**Cache Time**

This option (`'cache'`) defines the time in minutes to cache API requests. Setting it to 0 will disable caching. Normally, only GET requests are cached, however as a last parameter in requests, you may override this and ask other methods to be cached too. You may of course override a GET call with a custom cache time of your choosing. If the force no cache setting is enabled, this setting will be ignored. If you which to take advantage of caching, you should set this to to a value above 2. 15 minutes might be a good value. The default value for this setting is `0`.

**Force No Cache**

This option (`'force'`) defines if the caching should be forced off when the cache time is set to 0. This will ignore all overrides that would work before. If you which to take advantage of caching, you MUST set this to false. The default value for this setting is `true`.


## Usage

There is currently no usage documentation besides the [API Documentation](http://grahamcampbell.github.io/Laravel-Core-API
) for Laravel Core API.

You may see an example of implementation in [Laravel CloudFlare API](https://github.com/GrahamCampbell/Laravel-CloudFlare-API), [Laravel DigitalOcean API](https://github.com/GrahamCampbell/Laravel-DigitalOcean-API), or [Laravel UptimeRobot API](https://github.com/GrahamCampbell/Laravel-UptimeRobot-API).


## License

Apache License

Copyright 2013-2014 Graham Campbell

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

 http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
