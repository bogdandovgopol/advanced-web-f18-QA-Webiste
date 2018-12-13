<?php
/**
 * Created by PhpStorm.
 * User: 6472
 * Date: 11/12/2018
 * Time: 10:41 AM
 */

namespace QAClasses;


class Post extends Database
{
    public $tagClass;

    public function __construct()
    {
        parent::__construct();
        $this->tagClass = new Tag();
    }


    public function getAllPosts(){

        $posts = [];

        $query = "
            SELECT 
              post.id,
              post.title, 
              post.slug, 
              post.body
            FROM 
              post 
        ";

        $statement = $this->connection->prepare($query);
        $statement->execute();

        $result = $statement->get_result();

        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $row['tags'] = $this->tagClass->getTagsByPostId($row['id']);
                array_push($posts, $row);
            }
        }

        return $posts;
    }

    public function getPostById($id){

        $posts = [];

        $query = "
            SELECT 
              post.title, 
              post.slug, 
              post.body
            FROM 
              post
            WHERE
              post.id = ? 
        ";

        $statement = $this->connection->prepare($query);
        $statement->bind_param('i', $id);
        $statement->execute();

        $result = $statement->get_result();

        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $row['tags'] = $this->tagClass->getTagsByPostId($row['id']);
                array_push($posts, $row);
            }
        }

        return $posts;
    }

    public function getPostsByTagId($tagId){

        $posts = [];

        $query = "
            SELECT 
              post.id,
              post.title,
              post.slug,
              post.body
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

        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $row['tags'] = $this->tagClass->getTagsByPostId($row['id']);
                array_push($posts, $row);
            }
        }

        return $posts;
    }
}