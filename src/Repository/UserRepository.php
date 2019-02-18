<?php
/**
 * Created by PhpStorm.
 * User: bogdandovgopol
 * Date: 24/1/19
 * Time: 1:41 PM
 */

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{

    /**
     * @return null|User
     */
    public function getUserById(?string $id): ?User
    {
        $queryBuilder = $this->createQueryBuilder('u');
        $queryBuilder->where('u.id = :id');
        $queryBuilder->setParameters(['id' => $id]);

        try {
            return $queryBuilder->getQuery()->getSingleResult();
        } catch (\Exception $exception) {
            return null;
        }

    }

    /**
     * @return bool|User
     */
    public function getUserByEmail(?string $email)
    {
        $queryBuilder = $this->createQueryBuilder('u');
        $queryBuilder->where('u.email = :email');
        $queryBuilder->setParameters(['email' => $email]);

        try {
            return $queryBuilder->getQuery()->getSingleResult();
        } catch (\Exception $exception) {
            return null;
        }

    }
}