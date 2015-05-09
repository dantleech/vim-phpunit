" phpunitgen - Composer based PHPUnit test file generator
" Maintainer: Daniel Leech <daniel@dantleech.com>
" Version: 1.0

let s:genpath = expand('<sfile>:p:h') . '/../lib/generate-test.php'
let s:currentPath = expand('%:p')

echo s:genpath
execute '!php ' . s:genpath . ' ' . s:currentPath
