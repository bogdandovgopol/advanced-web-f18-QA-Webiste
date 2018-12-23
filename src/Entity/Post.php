<?php
/**
 * Created by PhpStorm.
 * User: bogdandovgopol
 * Date: 15/12/18
 * Time: 3:29 PM
 */

namespace App\Entity;


class Post
{
    private $id;
    private $title;
    private $slug;
    private $body;
    private $createdAt;
    private $updatedAt;

    private $tags;
    private $user;

    public function __construct()
    {
        $this->tags = [];
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
    {
        //slugify string. example: Adobe Photoshop => adobe-photoshop
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $slug)));

        $this->slug = $slug;
    }


    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function addTag(Tag $tag)
    {
        $this->tags[] = $tag;
    }

    public function removeTag(Tag $tag)
    {
        $key = array_search($tag, $this->tags, true);
        if ($key === false) {
            return false;
        }

        unset($this->tags[$key]);

        return true;
    }

    public function getTags(): ?array
    {
        return $this->tags;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    #### CUSTOM ####

    //this method is used only to populate entity with existing data from the database.
    public function set(int $id, string $title, string $slug, string $body, array $tags, \DateTime $createdAt, \DateTime $updatedAt): void
    {
        $this->id = $id;
        $this->title = $title;
        $this->slug = $slug;
        $this->body = $body;
        if (!empty($tags)) {
            foreach ($tags as $tag) {
                $this->addTag($tag);
            }
        }
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
}