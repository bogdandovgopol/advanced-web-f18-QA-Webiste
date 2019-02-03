<?php
/**
 * Created by PhpStorm.
 * User: bogdandovgopol
 * Date: 2019-01-31
 * Time: 00:25
 */

namespace App\Managers;


use App\Entity\User;
use App\Helper\Database;
use App\Helper\Validator;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class UserManager
{
    public static function getActiveUser(): ?User
    {
        //get repository
        $entityManager = (new Database())->getEntityManager();
        $userRepository = $entityManager->getRepository(User::class);

        //get user id fromm session
        $sessionUserId = SessionManager::getVars()['user_id'];

        //check if user_id session exists
        if (isset($sessionUserId))
            $user = $userRepository->getUserById($sessionUserId);
        else
            $user = null;

        return $user;
    }

    public static function signUp($firstName, $lastName, $email, $password, $avatar): array
    {
        // array to store errors
        $errors = [];

        //validate first name
        $validName = Validator::name($firstName);
        if ($validName['success'] == false) {
            $errors['firstName'] = $validName['errors'];
        }

        //validate last name
        $validName = Validator::name($firstName);
        if ($validName['success'] == false) {
            $errors['lastName'] = $validName['errors'];
        }

        //validate email
        $validEmail = Validator::email($email);
        if ($validEmail['success'] == false) {
            $errors['email'] = $validEmail['errors'];
        }

        //validate password
        $validPassword = Validator::password($password);
        if ($validPassword['success'] == false) {
            $errors['password'] = $validPassword['errors'];
        }

        //validate image if not empty since not required
        if ($avatar['size'] != 0) {
            $validImage = Validator::image($avatar);
            if ($validImage['success'] == false) {
                $errors['avatar'] = $validImage['errors'];
            }
        }


        //array for result
        $response = [];

        //check if there are errors
        if (count($errors) > 0) {
            //signup not successful
            $response['success'] = false;
            $response['errors'] = $errors;
            return $response;
        } else {
            //no errors
            //add user to our database

            //get entitymanager
            $entityManager = (new Database())->getEntityManager();

            $user = new User();
            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $user->setEmail($email);

            //get hash from the password
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $user->setPassword($passwordHash);

            //upload image if not empty since not required
            if ($avatar['size'] != 0) {
                $uploadedFilePath = self::uploadAvatar('avatar');
                $user->setAvatar($uploadedFilePath);
            } else {
                $user->setAvatar('public/images/avatars/default.jpg');
            }

            try {
                $entityManager->persist($user);
                $entityManager->flush();

                $response['email'] = $email;
                $response['user_id'] = $user->getId();
                $response['success'] = true;

                return $response;

            } catch (UniqueConstraintViolationException $exception) {
                $response['errors']['email'] = 'Email already exists';

                return $response;
            } catch (\Exception $exception) {
                $response['errors']['db'] = 'User cannot be added.';

                return $response;
            }

        }
    }

    public static function signIn($email, $password)
    {
        //get entitymanager
        $entityManager = (new Database())->getEntityManager();

        //get user
        $userRepository = $entityManager->getRepository(User::class);
        $user = $userRepository->getUserByEmail($email);

        //array for response
        $response = [];

        //check if user has been found
        if ($user == false) {
            //account does not exist
            $response['success'] = false;
            $response['user'] = $user;
            $response['error'] = 'Account does not exist';
        } else {
            $user_id = $user->getId();
            $hash = substr($user->getPassword(), 0, 60);
            //check user's password against the hash
            if (password_verify($password, $hash)) {
                //password matches hash
                $response['success'] = true;
                $response['user_id'] = $user_id;
            } else {
                //password does not match
                $response['success'] = false;
                $response['user'] = $user;
                $response['error'] = 'Wrong password';
            }
        }
        return $response;
    }

    public static function uploadAvatar(string $name, string $targetDir = 'public/images/avatars/')
    {

        $fileName = uniqid() . '-' . basename($_FILES[$name]["name"]);
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES[$name]["tmp_name"], $targetFile)) {
            return $targetFile;
        } else {
            return null;
        }

    }
}