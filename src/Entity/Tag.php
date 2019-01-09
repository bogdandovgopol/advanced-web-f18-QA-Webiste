<?php
/**
 * Created by PhpStorm.
 * User: bogdandovgopol
 * Date: 15/12/18
 * Time: 5:36 PM
 */

namespace App\Entity;


class Tag
{
    private $id;
    private $name;


    #### GETTERS AND SETTERS ####

    /**
     * @return mixed
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName(): ?string
    {
        //slugify string. example: Adobe Photoshop => adobe-photoshop
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $this->name)));
    }

    /**
     * @param mixed $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

}