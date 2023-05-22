<?php

require_once "../vendor/autoload.php";

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Symfony\Component\Dotenv\Dotenv;
use Doctrine\DBAL\Configuration;

$dotenv = new Dotenv();
$dotenv->load('../.env.local');

$isDevMode = true;
$proxyDir = null;
$cache = null;

$annotationConfig = ORMSetup::createAttributeMetadataConfiguration(
    ["app/models/entity"],
    true,
    $proxyDir,
    $cache
);

$connectionParams = [
    'dbname' => $_ENV['NAME_DB'],
    'user' => $_ENV['USERNAME_DB'],
    'password' => $_ENV['PASSWORD_DB'],
    'host' => $_ENV['HOST_DB'],
    'driver' => 'pdo_mysql',
    'charset' => 'utf8mb4'
];

$config = new Configuration();
$connection = DriverManager::getConnection($connectionParams, $config);

$entityManagerFactory = function () use ($annotationConfig, $connection) {
    return new EntityManager($connection, $annotationConfig);
};

return $entityManagerFactory;