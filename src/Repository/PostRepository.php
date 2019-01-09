<?php
/**
 * Created by PhpStorm.
 * User: bogdandovgopol
 * Date: 15/12/18
 * Time: 3:30 PM
 */

namespace App\Repository;


use App\Entity\Post;
use App\Entity\User;
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
              post.updated_at,
              users.full_name,
              users.email,
              users.admin,
              users.active,
              users.created_at AS user_created_at
            FROM 
              post 
            LEFT JOIN users ON post.user_id = users.id
        ";

        $statement = $this->connection->prepare($query);
        $statement->execute();

        $result = $statement->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $post = new Post();

                $post->setId($row['id']);
                $post->setTitle($row['title']);
                $post->setSlug($row['slug']);
                $post->setBody($row['body']);
                $post->setCreatedAt(new \DateTime($row['created_at']));
                $post->setCreatedAt(new \DateTime($row['updated_at']));

                //populate tags esnity
                $tags = $this->tagClass->getTagsByPostId($row['id']);
                foreach ($tags as $tag) {
                    $post->addTag($tag);
                }

                //populate users entity
                $user = new User();

                $user->setFullName($row['full_name']);
                $user->setEmail($row['email']);
                $user->setIsAdmin($row['admin']);
                $user->setIsActive($row['active']);
                $user->setCreatedAt(new \DateTime($row['user_created_at']));

                $post->setUser($user);

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
              post.updated_at,
              users.full_name,
              users.email,
              users.admin,
              users.active,
              users.created_at AS user_created_at
            FROM 
              post
            LEFT JOIN users ON post.user_id = users.id
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

                $post->setId($row['id']);
                $post->setTitle($row['title']);
                $post->setSlug($row['slug']);
                $post->setBody($row['body']);
                $post->setCreatedAt(new \DateTime($row['created_at']));
                $post->setCreatedAt(new \DateTime($row['updated_at']));

                //populate tags esnity
                $tags = $this->tagClass->getTagsByPostId($row['id']);
                foreach ($tags as $tag) {
                    $post->addTag($tag);
                }

                //populate users entity
                $user = new User();

                $user->setFullName($row['full_name']);
                $user->setEmail($row['email']);
                $user->setIsAdmin($row['admin']);
                $user->setIsActive($row['active']);
                $user->setCreatedAt(new \DateTime($row['user_created_at']));

                $post->setUser($user);

                $posts[] = $post;
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
              post.updated_at,
              users.full_name,
              users.email,
              users.admin,
              users.active,
              users.created_at AS user_created_at
            FROM 
              post
            LEFT JOIN users ON post.user_id = users.id
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

                $post->setId($row['id']);
                $post->setTitle($row['title']);
                $post->setSlug($row['slug']);
                $post->setBody($row['body']);
                $post->setCreatedAt(new \DateTime($row['created_at']));
                $post->setCreatedAt(new \DateTime($row['updated_at']));

                //populate tags esnity
                $tags = $this->tagClass->getTagsByPostId($row['id']);
                foreach ($tags as $tag) {
                    $post->addTag($tag);
                }

                //populate users entity
                $user = new User();

                $user->setFullName($row['full_name']);
                $user->setEmail($row['email']);
                $user->setIsAdmin($row['admin']);
                $user->setIsActive($row['active']);
                $user->setCreatedAt(new \DateTime($row['user_created_at']));

                $post->setUser($user);
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
              post.updated_at,
              users.full_name,
              users.email,
              users.admin,
              users.active,
              users.created_at AS user_created_at
            FROM 
              post 
            LEFT JOIN posts_tags ON post.id = posts_tags.post_id
            LEFT JOIN tag ON posts_tags.tag_id = tag.id
            LEFT JOIN users ON post.user_id = users.id
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

                $post->setId($row['id']);
                $post->setTitle($row['title']);
                $post->setSlug($row['slug']);
                $post->setBody($row['body']);
                $post->setCreatedAt(new \DateTime($row['created_at']));
                $post->setCreatedAt(new \DateTime($row['updated_at']));

                //populate tags esnity
                $tags = $this->tagClass->getTagsByPostId($row['id']);
                foreach ($tags as $tag) {
                    $post->addTag($tag);
                }

                //populate users entity
                $user = new User();

                $user->setFullName($row['full_name']);
                $user->setEmail($row['email']);
                $user->setIsAdmin($row['admin']);
                $user->setIsActive($row['active']);
                $user->setCreatedAt(new \DateTime($row['user_created_at']));

                $post->setUser($user);

                $posts[] = $post;
            }
        }

        return $posts;
    }


    /**
     * @return Post[]
     */
    public function search(?string $string): array
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
              post.updated_at,
              users.full_name,
              users.email,
              users.admin,
              users.active,
              users.created_at AS user_created_at
            FROM 
              post 
            LEFT JOIN posts_tags ON post.id = posts_tags.post_id
            LEFT JOIN tag ON posts_tags.tag_id = tag.id
            LEFT JOIN users ON post.user_id = users.id
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

                $post->setId($row['id']);
                $post->setTitle($row['title']);
                $post->setSlug($row['slug']);
                $post->setBody($row['body']);
                $post->setCreatedAt(new \DateTime($row['created_at']));
                $post->setCreatedAt(new \DateTime($row['updated_at']));

                //populate tags esnity
                $tags = $this->tagClass->getTagsByPostId($row['id']);
                foreach ($tags as $tag) {
                    $post->addTag($tag);
                }

                //populate users entity
                $user = new User();

                $user->setFullName($row['full_name']);
                $user->setEmail($row['email']);
                $user->setIsAdmin($row['admin']);
                $user->setIsActive($row['active']);
                $user->setCreatedAt(new \DateTime($row['user_created_at']));

                $post->setUser($user);

                $posts[] = $post;
            }
        }

        return $posts;
    }
}