<?php
/**
 * Created by PhpStorm.
 * User: bogdandovgopol
 * Date: 15/12/18
 * Time: 10:02 PM
 */

namespace App\Entity;


class User
{
    private $id;
    private $fullName;
    private $email;
    private $password;
    private $hash;
    private $isAdmin;
    private $isActive;
    private $lastIp;
    private $createdAt;

    private $posts;

    public function __construct()
    {
        $this->lastIp = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
        $this->hash = uniqid();
        $this->isActive = false;
        $this->isAdmin = false;

    }

    #### GETTERS AND SETTERS ####

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): void
    {
        $this->fullName = $fullName;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): ?string
    {
//        password_verify('gz711bsk96xi', $password)

        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $this->password = $password;
    }

    public function getIsAdmin(): ?bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(bool $isAdmin): void
    {
        $this->isAdmin = $isAdmin;
    }

    public function getisActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    public function getLastIp(): ?string
    {
        return $this->lastIp;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function addPost(Post $post): void
    {
        $this->posts[] = $post;
    }

    public function removePost(Post $post)
    {
        $key = array_search($post, $this->posts, true);
        if ($key === false) {
            return false;
        }

        unset($this->posts[$key]);

        return true;
    }

    public function getPosts(): ?array
    {
        return $this->posts;
    }

}