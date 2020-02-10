<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;



class Library
{
    private $id;

    private $name;

    private $description;

    private $createdAt;

    /**
     * @var Collection
     */
    private $books;

    public function __construct (string $name, string $description)
    {
        $this->setName($name);
        $this->setDescription($description);
        $date = new DateTime(date("Y-m-d"));
        $this->setCreatedAt($date);

    }
    public function removeBook(Book $book)
    {
        $this->books->removeElement($book);
    }
    public function addBook(Book $book)
    {
        $this->books->add($book);
    }
    public function getBooks(){
        return $this->books;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {

        $this->createdAt = $createdAt;
    }
}

