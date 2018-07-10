<?php

define('APPPATH', dirname(__FILE__) . '/');
define('BASEPATH', APPPATH . '/../system/');
define('ENVIRONMENT', 'development');

require APPPATH.'libraries/Doctrine.php';

require_once 'libraries/Doctrine/Common/ClassLoader.php';
$classLoader = new \Doctrine\Common\ClassLoader('Doctrine', APPPATH . '/libraries');
$classLoader->register();
$classLoader = new \Doctrine\Common\ClassLoader('Symfony', APPPATH . '/libraries/Doctrine');
$classLoader->register();



$doctrine = new Doctrine;
$em = $doctrine->em;

 $helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
));

 \Doctrine\ORM\Tools\Console\ConsoleRunner::run($helperSet);

?>