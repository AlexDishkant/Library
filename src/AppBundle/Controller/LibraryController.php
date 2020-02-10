<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Book;
use DateTime;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use Swagger\Annotations as SWG;
use Doctrine\Common\Annotations\DocLexer;
use AppBundle\Entity\Library;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Annotations\DocParser;



class LibraryController extends AbstractFOSRestController
{
    /**
     * @return Response
     * @SWG\Response(
     *      response="200",
     *      description="Show welcome library",
     * )
     */
    public function indexAction ()
    {
        return new Response('Welcome to my library!', Response::HTTP_OK,
            ['content-type' => 'text/html']);
    }

    /**
     * @return Response
     * @SWG\Post(
     *     tags={"library"},
     *     summary="Create library list",
     *     description="Create library list",
     *     produces={"application/json"},
     * @SWG\Parameter(
     *     name="name",
     *     in="formData",
     *     type="string",
     *     description="Name of library"
     * ),
     *     @SWG\Parameter(
     *     name="description",
     *     in="formData",
     *     type="string",
     *     description="description"
     * ),
     * @SWG\Response(
     *     response="200",
     *     description="Create library list"
     *     ),
     * )
     * @SWG\Tag(name="library")
     */
    public function createAction(Request $request)
    {
        $name = $request->request->get('name');
        $description = $request->request->get('description');
        $library = new Library(
            $name,
            $description
        );
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($library);
        $entityManager->flush();
        $data = [
            'library' => $library
        ];
        return $this->handleView(
            $this->view([ 'data' => $data], 200)
        );
    }

    /**
     * @return Response
     * @SWG\Post(
     *     tags={"library"},
     *     summary="Create library list",
     *     description="Create library list",
     *     produces={"application/json"},
     * @SWG\Parameter(
     *     name="title",
     *     in="formData",
     *     type="string",
     *     description="Name of book"
     *     ),
     * @SWG\Parameter(
     *     name="description",
     *     in="formData",
     *     type="string",
     *     description="description"
     *     ),
     * @SWG\Parameter(
     *     name="id",
     *     in="formData",
     *     type="string",
     *     description="Enter id of library"
     *     ),
     * @SWG\Response(
     *     response="200",
     *     description="Create library list"
     *     ),
     *  )
     * @SWG\Tag(name="library")
     *
     */
    public function addBookAction(Request $request)
    {
        $id = $request->request->get('id');
        $library = $this->getDoctrine()->getRepository('AppBundle:Library')->findOneById($id);
        $title = $request->request->get('title');
        $description = $request->request->get('description');
        $book = new Book(
            $title,
            $description,
            $library
        );
        $library->addBook($book);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($book);
        $entityManager->flush();
        $data = [
            'library' => $library,
        ];

        return $this->handleView(
            $this->view(['data' => $data], 300)
        );
    }

    /**
     * @SWG\POST(
     * 		tags={"book"},
     * 		operationId="deleteBook",
     * 		summary="Remove book entry",
     * @SWG\Parameter(
     * 	    name="library_id",
     *      in="formData",
     * 		type="integer",
     * 		description="Put a number library to delete book"
     *      ),
     *      @SWG\Parameter(
     * 	    name="book_id",
     *      in="formData",
     * 		type="integer",
     * 		description="Put a number to delete book"
     *      ),
     * @SWG\Response(
     * 	    response=200,
     * 		description="Call to a number",
     * 	  ),
     * @SWG\Tag(name="book")
     * )
     */
    public function removeBookAction(Request $request)
    {
        $libraryId = $request->request->get('library_id');
        $bookId = $request->request->get('book_id');
        $library = $this->getDoctrine()->getRepository('AppBundle:Library')->findOneById($libraryId);
        $book = $this->getDoctrine()->getRepository('AppBundle:Book')->findOneById($bookId);
        $library->removeBook($book);
        $entityManager = $this->getDoctrine()->getManager();

        if (!$library) {
            return $this->view("Service not found", Response::HTTP_NOT_FOUND);
        } else {
            $entityManager->remove($book);
            $entityManager->flush();

            return $this->view("**********Deleted successfully**********", Response::HTTP_OK);
        }
    }

    /**
     * @return Response
     * @SWG\Get(
     *     tags={"library"},
     *     summary="Get library list",
     *     description="Get library list",
     *     produces={"application/json"},
     * @SWG\Response(
     *     response="200",
     *     description="Delete library with books list"
     *     )
     * )
     * @SWG\Parameter(
     *     name="findAll()",
     *     in="query",
     *     type="string",
     *     description="The field used to show library with lists books"
     * )
     * @SWG\Tag(name="library")
     */
    public function showAction()
    {
        $library = $this->getDoctrine()
            ->getRepository('AppBundle:Library')
            ->findAll();
        $data = [
          'library'=> $library
        ];

        return $this->handleView(
            $this->view(['library'=>$data], 200)
            );
    }

    /**
     * @SWG\POST(
     * 		tags={"library"},
     * 		operationId="deleteLibrary",
     * 		summary="Remove library entry",
     * @SWG\Response(
     * 	    response=200,
     * 		description="Call to a number",
     * 	),
     * )
     * @SWG\Parameter(
     * 			name="id",
     *          in="formData",
     * 			type="integer",
     * 			description="Put a number to delete library"
     * )
     * @SWG\Tag(name="library")
     */
    public function deleteAction(Request $request)
    {
        $id = $request->request->get('id');
        $sn = $this->getDoctrine()->getManager();
        $library = $this->getDoctrine()->getRepository('AppBundle:Library')->findOneById($id);
        if (!$library) {
            return $this->view("Lybrary not found", Response::HTTP_NOT_FOUND);
        }
        else {
            $sn->remove($library);
            $sn->flush();
        }
        return $this->view("**********Deleted successfully**********", Response::HTTP_OK);
    }
}