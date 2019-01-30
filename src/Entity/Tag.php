<?php
/**
 * Created by PhpStorm.
 * User: bogdandovgopol
 * Date: 15/12/18
 * Time: 5:36 PM
 */

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 * @ORM\Table(name="tags")
 */
class Tag
{

    /**
     * @var integer
     *
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $name;


    #### GETTERS AND SETTERS ####

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        //slugify string. example: Adobe Photoshop => adobe-photoshop
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

}