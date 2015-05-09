<?php

// Generates a PHPUnit TestCase for the class at the given path
// with the given namespace prefix.
//
// Uses composer.json and reflection to generate the test
//
// @author Daniel Leech <daniel@dantleech.com>sc

function blowup($error)
{
    echo $error;
    exit(1);
}

function get_base_path($namespace) {
    global $autoload;
    $basePrefix = null;
    foreach ($autoload['psr-4'] as $prefix => $path) {
        $prefix = rtrim($prefix, '\\');
        if (0 === strpos($namespace, $prefix)) {
            $basePrefix = $prefix;
            $basePath = $path;
        }
    }

    return array($basePrefix, $basePath);
}

function mkdir_recursive($path)
{
    $parts = explode('/', $path);
    $paths = array();

    foreach ($parts as $part) {
        $paths[] = $part;
        $path = implode('/', $paths);
        if (!file_exists($path)) {
            mkdir($path);
        }
    }
}

$cwd = getcwd();
$file = $argv[1];
$composerFile = $cwd . '/composer.json';
$autoloadFile = $cwd . '/vendor/autoload.php';

if (isset($argv[2])) {
    $testNamespace = $argv[2];
} else {
    $testNamespace = '';
}

if (!file_exists($composerFile)) {
    blowup(sprintf('Could not find composer file in current directory (%s)', $cwd));
}

if (!file_exists($autoloadFile)) {
    blowup('Could not find autoload.php in vendor directory. Have you installed the dependencies for the project?');
}

if (!file_exists($file)) {
    blowup(sprintf('Could not find file "%s"', $file));
}

require_once($autoloadFile);

$composer = json_decode(file_get_contents($composerFile), true);
$classes = get_declared_classes();
require_once($file);
$diff = array_diff(get_declared_classes(), $classes);

if (empty($diff)) {
    blowup(sprintf('Could not determine class name for "%s"', $file));
}

$className = reset($diff);

$reflection = new \ReflectionClass($className);
$namespace = $reflection->getNamespaceName();

$autoload = $composer['autoload'];

if (isset($composer['autoload-dev'])) {
    $autoload = array_merge_recursive($autoload, $composer['autoload-dev']);
}

if (!isset($autoload['psr-4'])) {
    blowup('Only psr-4 autoloading supported');
}

global $autoload;

list($basePrefix, $basePath) = get_base_path($namespace);

$subNamespace = strstr($namespace, strlen($basePrefix));
$testNamespace = sprintf(
    '%s\\%s%s',
    $basePrefix,
    $testNamespace,
    $subNamespace ? '\\' . $subNamespace : ''
);
$testClassName = sprintf('%sTest', $reflection->getShortName());

list($testBasePrefix, $testBasePath) = get_base_path($testNamespace);

$testPath = sprintf(
    '%s%s',
    $testBasePath,
    str_replace('\\', '/', substr($testNamespace, strlen($testBasePrefix) + 1))
);

mkdir_recursive($testPath);

$testFile = sprintf(
    '%s/%sTest.php',
    $testPath,
    $reflection->getShortName()
);

if (file_exists($testFile)) {
    echo $testFile;
    exit(0);
}

$test = <<<EOT
<?php

namespace %s;

class %sTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
    }
}
EOT
;

file_put_contents($testFile, sprintf(
    $test,
    $testNamespace,
    $reflection->getShortName()
));

echo $testFile;
exit(0);
