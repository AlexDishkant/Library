<?php
namespace AppBundle\Entity;

use DateTime;
use Symfony\Component\Ldap\Adapter\ExtLdap\Collection;


class Book
{
    private $id;

    private $title;

    private $description;

    private $createdAt;
    /**
     * @var Collection
     */
    private  $library;


      public function __construct (string $title, string $description, Library $library)
      {
        $this->setTitle($title);
        $this->setDescription($description);
        $date = new DateTime(date("Y-m-d"));
        $this->setCreatedAt($date);
        $this->library = $library;
      }

      public function setLibrary (Library $library)
      {
         $this->library = $library;
      }


      public function getLibrary()
      {
           return $this->library;
      }

        public function setId($id)
        {
            $this->id = $id;
        }

        public function getTitle()
        {
            return $this->title;
        }

        public function setTitle($title)
        {
            $this->title = $title;
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