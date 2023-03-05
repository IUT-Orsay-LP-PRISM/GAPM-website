<?php

require_once "vendor/autoload.php";

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Symfony\Component\Dotenv\Dotenv;
use Doctrine\DBAL\Driver\PDOMySql\Driver as PDOMySqlDriver;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;


$dotenv = new Dotenv();
$dotenv->load('.env.local');


require_once 'vendor/autoload.php';

$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;

$annotationConfig = ORMSetup::createAttributeMetadataConfiguration(
    ["app/models/entity"],
    $isDevMode,
    $proxyDir,
    $cache
);

$connectionParams = [
    'dbname' => 'gapm',
    'user' => 'root',
    'password' => 'root',
    'host' => 'mariadb',
    'driver' => 'pdo_mysql',
];

$config = new Configuration();
$connection = DriverManager::getConnection($connectionParams, $config);


$entityManagerFactory = function () use ($annotationConfig, $connection) {
    return new EntityManager($connection, $annotationConfig);
};

return $entityManagerFactory;