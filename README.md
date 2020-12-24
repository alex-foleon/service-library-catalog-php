[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]

# service-library-catalog-php



127.0.0.1 host.docker.internal

docker exec -it rds-library bash -c "mysql -uroot -pmy-secret-pw -e \"create database catalogue CHARACTER SET utf8 COLLATE utf8_general_ci\""


Build a tiny REST API and use this to build 2 resources.
Books and Authors.

GET: /book/:id
Expect a book with the author

GET: /author/:id
Expect an author with all his books

POST: /author/
Create an author

POST: /book
Create a book and add an author to it.



Forked from: https://github.com/thephpleague/skeleton

**Note:** Replace ```Mr. Anon``` ```alex-foleon``` ```https://github.com/alex-foleon``` ```alex-foleon@example.com``` ```alex-foleon``` ```service-library-catalog-php``` `````` with their correct values in [README.md](README.md), [CHANGELOG.md](CHANGELOG.md), [CONTRIBUTING.md](CONTRIBUTING.md), [LICENSE.md](LICENSE.md) and [composer.json](composer.json) files, then delete this line. You can run `$ php prefill.php` in the command line to make all replacements at once. Delete the file prefill.php as well.

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what
PSRs you support to avoid any confusion with users and contributors.

## Structure

If any of the following are applicable to your project, then the directory structure should follow industry best practices by being named the following.

```
bin/        
build/
docs/
config/
src/
tests/
vendor/
```


## Install

Via Composer

``` bash
$ composer require alex-foleon/service-library-catalog-php
```

## Usage

``` php
$skeleton = new alex-foleon\service-library-catalog-php();
echo $skeleton->echoPhrase('Hello, League!');
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email alex-foleon@example.com instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/alex-foleon/service-library-catalog-php.svg?style=flat-square
[ico-travis]: https://travis-ci.com/github/alex-foleon/service-library-catalog-php.svg?branch=main
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/alex-foleon/service-library-catalog-php.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/alex-foleon/service-library-catalog-php.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/alex-foleon/service-library-catalog-php
[link-travis]: https://www.travis-ci.com/github/alex-foleon/service-library-catalog-php
[link-scrutinizer]: https://scrutinizer-ci.com/g/alex-foleon/service-library-catalog-php/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/alex-foleon/service-library-catalog-php
[link-downloads]: https://packagist.org/packages/alex-foleon/service-library-catalog-php
[link-author]: https://github.com/alex-foleon
[link-contributors]: ../../contributors
