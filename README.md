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
should be. By default it will prefix all test files with `Tests`.

This can be overridden as follows:

````vim
let g:phpunit_namespace_prefix="Tests\\Unit"
````

Mapping:

````vim
nnoremap <silent><leader>pt :call GeneratePhpunit()<CR>
````
