" phpunitgen - Composer based PHPUnit test file generator
"
" Author: Daniel Leech <daniel@dantleech.com>

let s:genpath = expand('<sfile>:p:h') . '/../lib/generate-test.php'

if !exists('g:phpunit_namespace_prefix')
    let g:phpunit_namespace_prefix = 'Tests\\Unit';
endif

function! GeneratePhpunit()
    let s:currentPath = expand('%:p')
    let testPath = system('php ' . s:genpath . ' ' ' ' . s:currentPath . ' ' . g:phpunit_namespace_prefix)
    execute 'open ' . testPath
endfunction
