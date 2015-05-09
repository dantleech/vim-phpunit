vim-phpunit
===========

Generates PHPUnit test case for the current class using Reflection and
`composer.json`.

Installation
------------

Using vundle:

````vim
Plugin 'dantleech/vim-phpunit'
````

Configuration
-------------

The plugin will use Reflection and composer to determine where the files
should be. By default it will prefix the sub-namespace all test files with `Tests`.

E.g. if your files namespace is `namespace MyProject\Bar\Doo` and composer is
configured with `{"MyProject\\": "foo/"}` then the test namespace will be `namespace
MyProject\Tests\Bar\Doo`.

This can be overridden as follows:

````vim
let g:phpunit_namespace_prefix="Tests\\Unit"
````

Mapping:

````vim
nnoremap <silent><leader>pt :call GeneratePhpunit()<CR>
````

Notes
-----

- Currently only works with `psr-4`
