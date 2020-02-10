<?php
namespace AppBundle\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use AppBundle\Entity\Book;
use FOS\RestBundle\Controller\Annotations\Route;
use Swagger\Annotations as SWG;
use Doctrine\Common\Annotations\DocLexer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Annotations\DocParser;


/**
 * Class BookController
 * @package AppBundle\Controller
 */
class BookController extends AbstractFOSRestController
{
    /**
     * @return Response
     * @SWG\Response(
     *      response="200",
     *      description="Show welcome library",
     * )
     */
    public function indexAction()
    {
        return new Response(
            'Welcome to my books!',
            Response::HTTP_OK,
            ['content-type' => 'text/html']
        );

    }

    /**
     * @return Response
     * @SWG\Get(
     *     tags={"books"},
     *     summary="Get books list",
     *     description="Get books list",
     *     produces={"application/json"},
     *     @SWG\Response(
     *          response="200",
     *          description="Show list of books"
     *     )
     * )
     * @SWG\Parameter(
     *     name="findAll()",
     *     in="query",
     *     type="string",
     *     description="The field used to order books"
     * )
     *
     * @SWG\Tag(name="books")
     */
    public function showBookAction()
    {
        $book = $this->getDoctrine()
            ->getRepository('AppBundle:Book')
            ->findAll();
        $data = [
            'book' => $book
        ];
        return $this->handleView(
            $this->view(['books'=> $data], 200)
        );

    }
}
