Laravel Core API
================


[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/GrahamCampbell/Laravel-Core-API/trend.png)](https://bitdeli.com/free "Bitdeli Badge")
[![Build Status](https://travis-ci.org/GrahamCampbell/Laravel-Core-API.png?branch=develop)](https://travis-ci.org/GrahamCampbell/Laravel-Core-API)
[![Coverage Status](https://coveralls.io/repos/GrahamCampbell/Laravel-Core-API/badge.png?branch=develop)](https://coveralls.io/r/GrahamCampbell/Laravel-Core-API)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/GrahamCampbell/Laravel-Core-API/badges/quality-score.png?s=a2f20fc191087f35712aa469b0225e1a2bf5d0fd)](https://scrutinizer-ci.com/g/GrahamCampbell/Laravel-Core-API)
[![Latest Version](https://poser.pugx.org/graham-campbell/core-api/v/stable.png)](https://packagist.org/packages/graham-campbell/core-api)
[![Still Maintained](http://stillmaintained.com/GrahamCampbell/Laravel-Core-API.png)](http://stillmaintained.com/GrahamCampbell/Laravel-Core-API)


## What Is Laravel Core API?

Laravel Core API provides some core API client functions for [Laravel 4.1](http://laravel.com).  

* Laravel Core API was created by, and is maintained by [Graham Campbell](https://github.com/GrahamCampbell).  
* Laravel Core API relies on the [Guzzle](https://github.com/guzzle/guzzle) package.  
* Laravel Core API uses [Travis CI](https://travis-ci.org/GrahamCampbell/Laravel-Core-API) to run tests to check if it's working as it should.  
* Laravel Core API uses [Scrutinizer CI](https://scrutinizer-ci.com/g/GrahamCampbell/Laravel-Core-API) and [Coveralls](https://coveralls.io/r/GrahamCampbell/Laravel-Core-API) to run additional tests and checks.  
* Laravel Core API uses [Composer](https://getcomposer.org) to load and manage dependencies.  
* Laravel Core API provides a [change log](https://github.com/GrahamCampbell/Laravel-Core-API/blob/develop/CHANGELOG.md), [releases](https://github.com/GrahamCampbell/Laravel-Core-API/releases), and a [wiki](https://github.com/GrahamCampbell/Laravel-Core-API/wiki).  
* Laravel Core API is licensed under the Apache License, available [here](https://github.com/GrahamCampbell/Laravel-Core-API/blob/develop/LICENSE.md).  


## System Requirements

* PHP 5.4.7+ or PHP 5.5+ is required.  
* You will need [Laravel 4.1](http://laravel.com) because this package is designed for it.  
* You will need [Composer](https://getcomposer.org) installed to load the dependencies of Laravel Core-API.  


## Installation

Please check the system requirements before installing Laravel Core API.  

To get the latest version of Laravel Core API, simply require it in your `composer.json` file.  

`"graham-campbell/core-api": "dev-master"`  

You'll then need to run `composer install` or `composer update` to download it and have the autoloader updated.  

Once Laravel Core API is installed, you need to register the service provider. Open up `app/config/app.php` and add the following to the `providers` key.  

`'GrahamCampbell\CoreAPI\CoreAPIServiceProvider'`  

You can register the CoreAPI facade in the `aliases` key of your `app/config/app.php` file if you like.  

`'CoreAPI' => 'GrahamCampbell\CoreAPI\Facades\CoreAPI'`  


## Usage

There is currently no usage documentation besides the [API Documentation](http://grahamcampbell.github.io/Laravel-Core-API
) for Laravel Core API.  

You may see an example of implementation in [Laravel CloudFlare API](https://github.com/GrahamCampbell/Laravel-CloudFlare-API),[Laravel DigitalOcean API](https://github.com/GrahamCampbell/Laravel-DigitalOcean-API), or [Laravel UptimeRobot API](https://github.com/GrahamCampbell/Laravel-UptimeRobot-API).  


## Updating Your Fork

The latest and greatest source can be found on [GitHub](https://github.com/GrahamCampbell/Laravel-Core-API).  
Before submitting a pull request, you should ensure that your fork is up to date.  

You may fork Laravel Core API:  

    git remote add upstream git://github.com/GrahamCampbell/Laravel-Core-API.git

The first command is only necessary the first time. If you have issues merging, you will need to get a merge tool such as [P4Merge](http://perforce.com/product/components/perforce_visual_merge_and_diff_tools).  

You can then update the branch:  

    git pull --rebase upstream develop
    git push --force origin <branch_name>

Once it is set up, run `git mergetool`. Once all conflicts are fixed, run `git rebase --continue`, and `git push --force origin <branch_name>`.  


## Pull Requests

Please submit pull requests against the develop branch.  

* Any pull requests made against the master branch will be closed immediately.  
* If you plan to fix a bug, please create a branch called `fix-`, followed by an appropriate name.  
* If you plan to add a feature, please create a branch called `feature-`, followed by an appropriate name.  
* Please follow PSR-2 standards except namespace declarations should be on the same line as `<?php`.  


## License

Apache License  

Copyright 2013 Graham Campbell  

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at  

 http://www.apache.org/licenses/LICENSE-2.0  

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.  
