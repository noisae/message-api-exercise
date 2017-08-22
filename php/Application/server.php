<?php
require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();
$database = new Medoo\Medoo([
    'database_type' => 'mysql',
    'database_name' => 'messageApi',
    'server' => 'mysql',
    'username' => 'root',
    'password' => 'root'
]);

// Infra
$messageRepository = new MessageApi\Infra\Repository\Message($database);

// Domain
$apiService = new MessageApi\Domain\Message\ApiService($messageRepository);

// Application
$messageRoute = new MessageApi\Application\Route\Message($app, $apiService);
$messageRoute->create();

// Athentication
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'admin' => array(
            'pattern' => "^/message",
            'http' => true,
            'users' => array(
                'admin' => array('ROLE_ADMIN', '$2y$13$MMRtVtSjA1fYaO19h/QAweE6AGVEFxtEyrnd55a6umOMGO0Zi7U5G'),
            ),
        ),
    ),
));

$app->run();
