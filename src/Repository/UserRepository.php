<?php
/**
 * Created by PhpStorm.
 * User: bogdandovgopol
 * Date: 24/1/19
 * Time: 1:41 PM
 */

namespace App\Repository;


use App\Entity\User;
use App\Helper\Database;

class UserRepository extends Database
{
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * @return User[]
     */
    public function getUsers(): array
    {
        $users = [];

        $query = "
            SELECT 
              *
            FROM 
              users
        ";

        $statement = $this->connection->prepare($query);
        $statement->execute();

        $result = $statement->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $user = new User();

                $user->setId($row['id']);
                $user->setFullName($row['full_name']);
                $user->setEmail('emmail');
                $user->setIsActive(true);
                $user->setIsAdmin(false);
                $user->setPassword('password');

                $users[] = $user;
            }
        }

        return $users;
    }

}