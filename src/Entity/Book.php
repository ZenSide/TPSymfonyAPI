<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $author;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $row;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cell;

    /**
     * @ORM\ManyToOne(targetEntity=BookStyle::class, inversedBy="books")
     */
    private $style;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getRow(): ?int
    {
        return $this->row;
    }

    public function setRow(int $row): self
    {
        $this->row = $row;

        return $this;
    }

    public function getCell(): ?int
    {
        return $this->cell;
    }

    public function setCell(int $cell): self
    {
        $this->cell = $cell;

        return $this;
    }

    public function getStyle(): ?BookStyle
    {
        return $this->style;
    }

    public function setStyle(?BookStyle $style): self
    {
        $this->style = $style;

        return $this;
    }
}
