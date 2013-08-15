Laravel Core API
================


[![Latest Stable Version](https://poser.pugx.org/graham-campbell/core-api/v/stable.png)](https://packagist.org/packages/graham-campbell/core-api)
[![Build Status](https://travis-ci.org/GrahamCampbell/Laravel-Core-API.png?branch=master)](https://travis-ci.org/GrahamCampbell/Laravel-Core-API)
[![Latest Unstable Version](https://poser.pugx.org/graham-campbell/core-api/v/unstable.png)](https://packagist.org/packages/graham-campbell/core-api)
[![Build Status](https://travis-ci.org/GrahamCampbell/Laravel-Core-API.png?branch=develop)](https://travis-ci.org/GrahamCampbell/Laravel-Core-API)
[![Total Downloads](https://poser.pugx.org/graham-campbell/core-api/downloads.png)](https://packagist.org/packages/graham-campbell/core-api)
[![Still Maintained](http://stillmaintained.com/GrahamCampbell/Laravel-Core-API.png)](http://stillmaintained.com/GrahamCampbell/Laravel-Core-API)


[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/GrahamCampbell/laravel-core-api/trend.png)](https://bitdeli.com/free "Bitdeli Badge")


Copyright © [Graham Campbell](https://github.com/GrahamCampbell) 2013  


## THIS ALPHA RELEASE IS FOR TESTING ONLY


## What Is Laravel Core API?

Laravel Core API Provides Some Core API Client Functions For [Laravel 4](http://laravel.com).  

* Laravel Core API was created by, and is maintained by [Graham Campbell](https://github.com/GrahamCampbell).  
* Laravel Core API relies on the [Guzzle](https://github.com/guzzle/guzzle) package for web requests.  
* Laravel Core API uses [Travis CI](https://travis-ci.org/GrahamCampbell/Laravel-Core-API) to run tests to check if it's working as it should.  
* Laravel Core API uses [Composer](https://getcomposer.org) to load and manage dependencies.  
* Laravel Core API provides a [change log](https://github.com/GrahamCampbell/Laravel-Core-API/blob/master/CHANGELOG.md), [releases](https://github.com/GrahamCampbell/Laravel-Core-API/releases), and a [wiki](https://github.com/GrahamCampbell/Laravel-Core-API/wiki).  
* Laravel Core API is licensed under the MIT, available [here](https://github.com/GrahamCampbell/Laravel-Core-API/blob/master/LICENSE.md).  


## System Requirements

* PHP 5.3.3+, 5.4+ or PHP 5.5+ is required.
* You will need [Laravel 4](http://laravel.com) because this package is designed for it.  
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


## Updating Your Fork

The latest and greatest source can be found on [GitHub](https://github.com/GrahamCampbell/Laravel-Core-API).  
Before submitting a pull request, you should ensure that your fork is up to date.  

You may fork Laravel Core API:  

    git remote add upstream git://github.com/GrahamCampbell/Laravel-Core-API.git

The first command is only necessary the first time. If you have issues merging, you will need to get a merge tool such as [P4Merge](http://perforce.com/product/components/perforce_visual_merge_and_diff_tools).  

You can then update the branch:  

    git pull --rebase upstream master
    git push --force origin <branch_name>

Once it is set up, run `git mergetool`. Once all conflicts are fixed, run `git rebase --continue`, and `git push --force origin <branch_name>`.  


## License

The MIT License (MIT)

Copyright (c) 2013 Graham Campbell

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
