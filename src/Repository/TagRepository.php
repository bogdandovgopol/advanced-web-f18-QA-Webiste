<?php
/**
 * Created by PhpStorm.
 * User: 6472
 * Date: 11/12/2018
 * Time: 10:41 AM
 */

namespace App\Repository;

use App\Entity\Tag;
use App\Helper\Database;

class TagRepository extends Database
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return Tag[]
     */
    public function getAllTags(): array
    {

        $tags = [];

        $query = "
            SELECT 
              tag.id,
              tag.name
            FROM 
              tag 
        ";

        $statement = $this->connection->prepare($query);
        $statement->execute();

        $result = $statement->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                $tag = new Tag();
                $tag->set($row['id'], $row['name']);

                $tags[] = $tag;
            }
        }

        return $tags;
    }

    public function getTagById($id)
    {

        $tag = new Tag();

        $query = "
            SELECT 
              tag.id,
              tag.name
            FROM 
              tag 
            WHERE
              tag.id = ? 
            LIMIT 1
        ";

        $statement = $this->connection->prepare($query);
        $statement->bind_param('i', $id);
        $statement->execute();

        $result = $statement->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tag->set($row['id'], $row['name']);
            }
        }

        return $tag;
    }

    /**
     * @return Tag[]
     */
    public function getTagsByPostId($postId)
    {

        $tags = [];

        $query = "
            SELECT 
              tag.id,
              tag.name
            FROM 
              post 
            LEFT JOIN posts_tags ON post.id = posts_tags.post_id
            LEFT JOIN tag ON posts_tags.tag_id = tag.id
            WHERE 
              post.id = ?
        ";

        $statement = $this->connection->prepare($query);
        $statement->bind_param('i', $postId);
        $statement->execute();

        $result = $statement->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                $tag = new Tag();
                $tag->set($row['id'], $row['name']);

                $tags[] = $tag;
            }
        }

        return $tags;
    }
}