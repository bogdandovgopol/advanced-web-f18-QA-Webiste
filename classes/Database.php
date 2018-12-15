<?php
/**
 * Created by PhpStorm.
 * User: 6472
 * Date: 11/12/2018
 * Time: 10:35 AM
 */

namespace QAClasses;

class Database
{
    protected $connection;

    protected function __construct()
    {
        try{
            $conn = mysqli_connect("localhost", "root", "", "qa_xyz");
//            $conn = mysqli_connect(getenv("DB_HOST"), getenv("DB_USER"), getenv("DB_PASSWORD"), getenv("DB_NAME"));

            if($conn){
                $this->connection = $conn;
            } else{
                throw new \Exception("Connection to database failed :(");
            }
        } catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
}