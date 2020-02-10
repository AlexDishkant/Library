<?php
namespace AppBundle\Repository;

use AppBundle\Entity\Library;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class BookRepository extends EntityRepository
{
    public function findAllByName()
    {
        return $this->getDoctrine()
            ->createQuery(
                'SELECT p FROM AppBundle:Library p ORDER BY p.name ASC'
            )
            ->getResult();
    }
    public function listAction()
    {
        $libraries = $this->getDoctrine()
            ->getRepository(Library::class)
            ->findAllByName();
    }
}