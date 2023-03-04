<?php
// bootstrap.php
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Attributes
$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: array(__DIR__."/app/models/entity"),
    isDevMode: true,
);

// configuring the database connection
$connection = DriverManager::getConnection([
    'driver'   => 'pdo_mysql',
    'user'     => $_ENV['USERNAME_DB'],
    'password' => $_ENV['PASSWORD_DB'],
    'dbname'   => $_ENV['NAME_DB'],
], $config);

// obtaining the entity manager
$entityManager = new EntityManager($connection, $config);