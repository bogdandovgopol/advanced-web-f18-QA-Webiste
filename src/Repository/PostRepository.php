<?php
/**
 * Created by PhpStorm.
 * User: bogdandovgopol
 * Date: 15/12/18
 * Time: 3:30 PM
 */

namespace App\Repository;


use App\Entity\Post;
use App\Helper\Database;

class PostRepository extends Database
{
    public $tagClass;

    public function __construct()
    {
        parent::__construct();
        $this->tagClass = new TagRepository();
    }

    /**
     * @return Post[]
     */
    public function getAllPosts(): array
    {

        $posts = [];

        $query = "
            SELECT 
              post.id,
              post.title, 
              post.slug, 
              post.body,
              post.created_at,
              post.updated_at
            FROM 
              post 
        ";

        $statement = $this->connection->prepare($query);
        $statement->execute();

        $result = $statement->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $post = new Post();

                $tags = $this->tagClass->getTagsByPostId($row['id']);

                $post->set($row['id'], $row['title'], $row['slug'], $row['body'], $tags, new \DateTime($row['created_at']), new \DateTime($row['updated_at']));

                $posts[] = $post;
            }
        }

        return $posts;
    }

    public function getPostById(int $id): ?Post
    {

        $post = null;

        $query = "
            SELECT 
              post.id,
              post.title, 
              post.slug, 
              post.body,
              post.created_at,
              post.updated_at
            FROM 
              post
            WHERE
              post.id = ? 
            LIMIT 1
        ";

        $statement = $this->connection->prepare($query);
        $statement->bind_param('i', $id);
        $statement->execute();

        $result = $statement->get_result();

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                $post = new Post();

                $tags = $this->tagClass->getTagsByPostId($row['id']);

                $post->set($row['id'], $row['title'], $row['slug'], $row['body'], $tags, new \DateTime($row['created_at']), new \DateTime($row['updated_at']));
            }

        }

        return $post;
    }

    public function getPostBySlug(string $slug): ?Post
    {

        $post = null;

        $query = "
            SELECT 
              post.id,
              post.title, 
              post.slug, 
              post.body,
              post.created_at,
              post.updated_at
            FROM 
              post
            WHERE
              post.slug = ? 
            LIMIT 1
            
        ";

        $statement = $this->connection->prepare($query);
        $statement->bind_param('s', $slug);
        $statement->execute();


        $result = $statement->get_result();


        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                $post = new Post();

                $tags = $this->tagClass->getTagsByPostId($row['id']);

                $post->set($row['id'], $row['title'], $row['slug'], $row['body'], $tags, new \DateTime($row['created_at']), new \DateTime($row['updated_at']));
            }

        }

        return $post;
    }

    /**
     * @return Post[]
     */
    public function getPostsByTagId($tagId): array
    {

        $posts = [];

        $query = "
            SELECT 
              post.id,
              post.title,
              post.slug,
              post.body,
              post.created_at,
              post.updated_at
            FROM 
              post 
            LEFT JOIN posts_tags ON post.id = posts_tags.post_id
            LEFT JOIN tag ON posts_tags.tag_id = tag.id
            WHERE 
              tag.id = ?
        ";

        $statement = $this->connection->prepare($query);
        $statement->bind_param('i', $tagId);
        $statement->execute();

        $result = $statement->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                $post = new Post();

                $tags = $this->tagClass->getTagsByPostId($row['id']);

                $post->set($row['id'], $row['title'], $row['slug'], $row['body'], $tags, new \DateTime($row['created_at']), new \DateTime($row['updated_at']));

                $posts[] = $post;
            }
        }

        return $posts;
    }


    /**
     * @return Post[]
     */
    public function search(string $string): array
    {

        $string = "%$string%";
        $posts = [];

        $query = "
            SELECT 
              post.id,
              post.title,
              post.slug,
              post.body,
              post.created_at,
              post.updated_at
            FROM 
              post 
            LEFT JOIN posts_tags ON post.id = posts_tags.post_id
            LEFT JOIN tag ON posts_tags.tag_id = tag.id
            WHERE 
              post.title LIKE ?
              OR 
              tag.name LIKE ?
              
        ";

        $statement = $this->connection->prepare($query);
        $statement->bind_param('ss', $string, $string);
        $statement->execute();

        $result = $statement->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                $post = new Post();

                $tags = $this->tagClass->getTagsByPostId($row['id']);

                $post->set($row['id'], $row['title'], $row['slug'], $row['body'], $tags, new \DateTime($row['created_at']), new \DateTime($row['updated_at']));

                $posts[] = $post;
            }
        }

        return $posts;
    }
}