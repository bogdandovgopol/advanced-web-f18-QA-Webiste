<?php
/**
 * Created by PhpStorm.
 * User: 6472
 * Date: 11/12/2018
 * Time: 10:41 AM
 */

namespace QAClasses;


class Tag extends Database
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllTags(){

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

        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                array_push($tags, $row);
            }
        }

        return $tags;
    }

    public function getTagById($id){

        $tags = [];

        $query = "
            SELECT 
              tag.id,
              tag.name
            FROM 
              tag 
            WHERE
              tag.id = ? 
        ";

        $statement = $this->connection->prepare($query);
        $statement->bind_param('i', $id);
        $statement->execute();

        $result = $statement->get_result();

        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                array_push($tags, $row);
            }
        }

        return $tags;
    }

    public function getTagsByPostId($postId){

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

        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                array_push($tags, $row);
            }
        }

        return $tags;
    }
}