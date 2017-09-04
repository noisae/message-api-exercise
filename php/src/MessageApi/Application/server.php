<?php
use Silex\Provider\SecurityServiceProvider;
use Silex\Application;
use Medoo\Medoo;
use MessageApi\Infra\Repository\MessageRepository;
use MessageApi\Infra\Repository\Parser\MessageEntityParser;
use MessageApi\Domain\MessageApi;
use MessageApi\Application\Route\MessageRoute;

$app = new Application();
$database = new Medoo([
    'database_type' => 'mysql',
    'database_name' => 'messageApi',
    'server' => 'mysql',
    'username' => 'root',
    'password' => 'root'
]);

// Infra
$messageEntityParser = new MessageEntityParser();
$messageRepository = new MessageRepository($database, $messageEntityParser);

// Domain
$messageApi = new MessageApi($messageRepository);

// Application
$messageRoute = new MessageRoute($app, $messageApi);
$messageRoute->register();

// Athentication
$app->register(new SecurityServiceProvider(), array(
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
