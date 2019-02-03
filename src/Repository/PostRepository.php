<?php
/**
 * Created by PhpStorm.
 * User: bogdandovgopol
 * Date: 2019-01-30
 * Time: 20:45
 */

namespace App\Repository;


use App\Entity\Post;
use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
    public function getPostsByTagName(string $tagName)
    {
        $queryBuilder = $this->createQueryBuilder('p');
        $queryBuilder->leftJoin('p.tags', 'tag');
        $queryBuilder->where('tag.name = :tagName');
        $queryBuilder->setParameter('tagName', $tagName);

        return $queryBuilder->getQuery()->getResult();

    }

    public function leaveComment()
    {

    }


    //SEARCH:

    /**
     * @return Post[]
     */
    public function findBySearchQuery(string $rawQuery): array
    {
        $query = $this->sanitizeSearchQuery($rawQuery);
        $searchTerms = $this->extractSearchTerms($query);

        if (0 === \count($searchTerms)) {
            return [];
        }

        $queryBuilder = $this->createQueryBuilder('p');
        $queryBuilder->leftJoin('p.tags', 'tags');

        foreach ($searchTerms as $key => $term) {
            $queryBuilder->orWhere('p.title LIKE :t_' . $key);
            $queryBuilder->orWhere('tags.name LIKE :t_' . $key);
            $queryBuilder->setParameter('t_' . $key, '%' . $term . '%');
        }

        return $queryBuilder->orderBy('p.publishedAt', 'DESC')->getQuery()->getResult();
    }

    /**
     * Removes all non-alphanumeric characters except whitespaces.
     */
    private function sanitizeSearchQuery(string $query): string
    {
        return trim(preg_replace('/[[:space:]]+/', ' ', $query));
    }

    /**
     * Splits the search query into terms and removes the ones which are irrelevant.
     */
    private function extractSearchTerms(string $searchQuery): array
    {
        $terms = array_unique(explode(' ', $searchQuery));
        return array_filter($terms, function ($term) {
            return 2 <= mb_strlen($term);
        });
    }

}