<?php
/**
 * Created by PhpStorm.
 * User: bogdandovgopol
 * Date: 2019-01-30
 * Time: 20:45
 */

namespace App\Repository;


use App\Entity\Post;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;

class CommentRepository extends EntityRepository
{
    public function getCommentByIDAndUser(int $id)
    {
        $queryBuilder = $this->createQueryBuilder('c');
        $queryBuilder->leftJoin('c.author', 'author');
        $queryBuilder->where('c.id = :id');
        $queryBuilder->setParameters(['id' => $id]);

        try {
            return $queryBuilder->getQuery()->getSingleResult();
        } catch (\Exception $exception) {
            return null;
        }

    }
}