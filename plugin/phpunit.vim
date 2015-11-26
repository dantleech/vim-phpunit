" phpunitgen - Composer based PHPUnit test file generator
"
" Author: Daniel Leech <daniel@dantleech.com>

let s:genpath = expand('<sfile>:p:h') . '/../lib/generate-test.php'
let s:phpunitpath = '/usr/local/bin/phpunit'
let s:phpunitargs = '--stop-on-error --stop-on-failure'

if !exists('g:phpunit_namespace_prefix')
    let g:phpunit_namespace_prefix = 'Tests\\Unit'
endif

function! PhpunitGenerate()
    let currentPath = expand('%:p')
    let testPath = system('php ' . s:genpath . ' ' . currentPath . ' ' . g:phpunit_namespace_prefix)
    
    if (v:shell_error == 0)
        execute 'edit ' . testPath
    else 
        echoerr testPath
    endif

endfunction

function! PhpunitRun()
    silent !clear
    let currentPath = expand('%:p')
    execute '!' . s:phpunitpath . ' ' . s:phpunitargs . ' ' . currentPath
endfunction
