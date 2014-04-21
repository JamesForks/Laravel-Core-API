Laravel Core API
================


[![Build Status](https://img.shields.io/travis/GrahamCampbell/Laravel-Core-API/master.svg)](https://travis-ci.org/GrahamCampbell/Laravel-Core-API)
[![Coverage Status](https://img.shields.io/coveralls/GrahamCampbell/Laravel-Core-API/master.svg)](https://coveralls.io/r/GrahamCampbell/Laravel-Core-API)
[![Software License](https://img.shields.io/badge/license-Apache%202.0-brightgreen.svg)](https://github.com/GrahamCampbell/Laravel-Core-API/blob/master/LICENSE.md)
[![Latest Version](https://img.shields.io/github/release/GrahamCampbell/Laravel-Core-API.svg)](https://github.com/GrahamCampbell/Laravel-Core-API/releases)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/GrahamCampbell/Laravel-Core-API/badges/quality-score.png?s=a2f20fc191087f35712aa469b0225e1a2bf5d0fd)](https://scrutinizer-ci.com/g/GrahamCampbell/Laravel-Core-API)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/fd28e11f-7e03-4835-8952-db9b4ecf34ba/mini.png)](https://insight.sensiolabs.com/projects/fd28e11f-7e03-4835-8952-db9b4ecf34ba)


## What Is Laravel Core API?

Laravel Core API provides some core API client functions for [Laravel 4.1](http://laravel.com).

* Laravel Core API was created by, and is maintained by [Graham Campbell](https://github.com/GrahamCampbell).
* Laravel Core API relies on the [Guzzle](https://github.com/guzzle/guzzle) package.
* Laravel Core API uses [Travis CI](https://travis-ci.org/GrahamCampbell/Laravel-Core-API) with [Coveralls](https://coveralls.io/r/GrahamCampbell/Laravel-Core-API) to check everything is working.
* Laravel Core API uses [Scrutinizer CI](https://scrutinizer-ci.com/g/GrahamCampbell/Laravel-Core-API) and [SensioLabsInsight](https://insight.sensiolabs.com/projects/fd28e11f-7e03-4835-8952-db9b4ecf34ba) to run additional checks.
* Laravel Core API uses [Composer](https://getcomposer.org) to load and manage dependencies.
* Laravel Core API provides a [change log](https://github.com/GrahamCampbell/Laravel-Core-API/blob/master/CHANGELOG.md), [releases](https://github.com/GrahamCampbell/Laravel-Core-API/releases), and [api docs](http://grahamcampbell.github.io/Laravel-Core-API).
* Laravel Core API is licensed under the Apache License, available [here](https://github.com/GrahamCampbell/Laravel-Core-API/blob/master/LICENSE.md).


## System Requirements

* PHP 5.4.7+ or HHVM 3.0+ (Guzzle 3.8 isn't completely HHVM compatible).
* You will need [Laravel 4.1](http://laravel.com) because this package is designed for it.
* You will need [Composer](https://getcomposer.org) installed to load the dependencies of Laravel Core-API.


## Installation

Please check the system requirements before installing Laravel Core API.

To get the latest version of Laravel Core API, simply require `"graham-campbell/core-api": "0.5.*@alpha"` in your `composer.json` file. You'll then need to run `composer install` or `composer update` to download it and have the autoloader updated.

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


## Updating Your Fork

Before submitting a pull request, you should ensure that your fork is up to date.

You may fork Laravel Core API:

    git remote add upstream git://github.com/GrahamCampbell/Laravel-Core-API.git

The first command is only necessary the first time. If you have issues merging, you will need to get a merge tool such as [P4Merge](http://perforce.com/product/components/perforce_visual_merge_and_diff_tools).

You can then update the branch:

    git pull --rebase upstream master
    git push --force origin <branch_name>

Once it is set up, run `git mergetool`. Once all conflicts are fixed, run `git rebase --continue`, and `git push --force origin <branch_name>`.


## Pull Requests

Please review these guidelines before submitting any pull requests.

* When submitting bug fixes, check if a maintenance branch exists for an older series, then pull against that older branch if the bug is present in it.
* Before sending a pull request for a new feature, you should first create an issue with [Proposal] in the title.
* Please follow the [PSR-2 Coding Style](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) and [PHP-FIG Naming Conventions](https://github.com/php-fig/fig-standards/blob/master/bylaws/002-psr-naming-conventions.md).


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
