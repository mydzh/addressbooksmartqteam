<?php
declare(strict_types=1);

error_reporting(E_ERROR | E_WARNING | E_PARSE); ini_set('display_errors', '1');

spl_autoload_register(function ($class) {
    // project-specific namespace prefix
    $prefix = 'App\\';

    // base directory for the namespace prefix
    $base_dir = __DIR__ . '/../src/' . lcfirst($prefix);

    // does the class use the namespace prefix?
    $len = strlen($prefix);

    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }

    $relative_class = substr($class, $len);
    $file =  str_replace('\\', '/', $base_dir . $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

$app = new App\Application();
$app->edit();
?>
