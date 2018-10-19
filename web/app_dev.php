<?php

use Symfony\Component\Debug\Debug;
use Symfony\Component\DependencyInjection\Exception\EnvParameterException;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;

// This check prevents access to debug front controllers that are deployed by accident to production servers.
// Feel free to remove this, extend it, or make something more sophisticated.
if (isset($_SERVER['HTTP_CLIENT_IP'])
    || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
    || PHP_SAPI === 'cli-server'
) {
    header('HTTP/1.0 403 Forbidden');
    exit('You are not allowed to access this file.');
}
if (getenv('APP_ENV') === 'prod') {
    header('HTTP/1.0 404 Not Found');
    exit;
}

require __DIR__.'/../vendor/autoload.php';

$dotEnv =new Dotenv();
$dotEnv->load(__DIR__.'/../.env');

$env = getenv('APP_ENV');
if (!in_array($env, ['dev', 'test', 'staging'])) {
    throw new EnvParameterException([$env]);
}
$debug = false;
if (in_array($env, ['dev', 'test'])) {
    $debug = true;
    Debug::enable();
}

$kernel = new AppKernel($env, $debug);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
