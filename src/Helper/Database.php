<?php
/**
 * Created by PhpStorm.
 * User: bogdandovgopol
 * Date: 2019-01-30
 * Time: 19:04
 */

namespace App\Helper;


use App\Helper\Exception\ServerInternalErrorHttpException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class Database
{
    protected $entityManager;

    public function __construct()
    {
        // Create a simple "default" Doctrine ORM configuration for Annotations
        $isDevMode = true;
        $config = Setup::createAnnotationMetadataConfiguration(array('src'), $isDevMode, null, null, false);

        // database configuration parameters
        $conn = array(
            'driver' => 'pdo_mysql',
            'host' => 'host.appletrh.ovh',
            'dbname' => 'qa_xyz',
            'user' => 'xyz',
            'password' => '12345',
        );

        try {
            // obtaining the entity manager
            $this->entityManager = EntityManager::create($conn, $config);
        } catch (\Exception $exception) {
            return new ServerInternalErrorHttpException($exception->getMessage());
        }
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }
}