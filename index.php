<?php
header('Location: /public');
exit;


use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/vendor/autoload.php';
// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/bootstrap/app.php')
    ->handleRequest(Request::capture());

/*

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = '/home/yox8gc0h2lov/myrecp-root/storage/framework/maintenance.php')) {
    require $maintenance;
}
try{
// Register the Composer autoloader...
require '/home/yox8gc0h2lov/myrecp-root/vendor/autoload.php';
// Bootstrap Laravel and handle the request...
(require_once '/home/yox8gc0h2lov/myrecp-root/bootstrap/app.php')
    ->handleRequest(Request::capture());
}catch( \Throwable $e){
    print_r( $e->getMessage());
}
*/