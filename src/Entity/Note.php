<?php

namespace App\Entity;

use App\Validator as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @AppAssert\NoteUnique
 * @ORM\Entity(repositoryClass=App\Repository\NoteRepository::class)
 */
class Note
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="The description field cannot be empty")
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @Assert\NotBlank(message="The title field cannot be empty")
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_created;

    /**
     * @ORM\Column(type="boolean")
     */
    private $finish;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDateCreated(): ?string
    { 
        return $this->date_created->format('d-m-Y H:m:i');
    }

    public function setDateCreated()
    {
        $this->date_created = new \DateTime();

        return $this;
    }

    public function getFinish(): ?bool
    {
        return $this->finish;
    }

    public function setFinish(bool $finish): self
    {
        $this->finish = $finish;

        return $this;
    }
}
