vim-phpunit
===========

Generates and opens an empty (or the existing) PHPUnit test case for the
current class using Reflection and `composer.json`.

For example, if your file's namespace is `namespace MyProject\Bar\Doo` and
composer autoload is configured with `{"MyProject\\": "foo/"}` then the test
namespace will be `namespace MyProject\Tests\Bar\Doo` and the test will
created at `foo/Tests/Bar/DooTest.php`

If you have defined a specific location for tests in your `composer.json` then
that path will be used, for example:

````php
{
    "autoload": {
        "psr-4": {
            "MyProject\\": "src/"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "MyProject\\Tests\\": "tests/"
        }
    }
}
````

The generated test namespace will match the `autoload-dev` entry, and the test
will be created at `tests/Bar/DooTest.php`.

Installation
------------

Using vundle:

````vim
Plugin 'dantleech/vim-phpunit'
````

Configuration
-------------

By default it will prefix the sub-namespace with `Tests`, this can be
overridden as follows:

````vim
let g:phpunit_namespace_prefix="Tests\\Unit"
````

You can also chane the path to phpunit:

````vim
let g:phpunitpath="/usr/local/bin/phpunit"
````

Mapping:

````vim
nnoremap <silent><leader>pt :call PhpunitGenerate()<CR>
nnoremap <silent><leader>pp :call PhpunitRun()<CR>
````

Notes
-----

- Currently only works with `psr-4`
