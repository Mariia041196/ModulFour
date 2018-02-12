<?php
namespace Controller;
use Framework\BaseController;
use Framework\Request;
use Framework\Exception\NotFoundException;
use Model\Repository\BookRepository;
use Model\Pagination\Pagination;
class BookController extends BaseController
{
    const BOOKS_PER_PAGE = 12;

    public function indexAction(Request $request)
    {
        $page = $request->get('page', 1);
        $repo =  $this->getRepository('Book');

        $count = $repo->count();
        $books = $repo
            ->findAll([
                'current_page' => $page,
                'items_on_page' => self::BOOKS_PER_PAGE
            ])
        ;

        $pagination = new Pagination([
            'itemsCount' => $count,
            'itemsPerPage' => self::BOOKS_PER_PAGE,
            'currentPage' => $page
        ]);

        return $this->render('index.html.twig', [
            'books' => $books,
            'pagination' => $pagination
        ]);
    }

    public function apiIndexAction(Request $request)
    {
        $page = $request->get('page', 1);
        $repo =  $this->getRepository('Book');

        $books = $repo
            ->findAll([
                'current_page' => $page,
                'items_on_page' => self::BOOKS_PER_PAGE
            ], $hydrationArray = true)
        ;

        header('content-type: application/json');

        return json_encode($books);
    }

    public function showAction(Request $request)
    {
        $id = $request->get('id'); // $_GET['id']
        $book = $this
            ->getRepository('Book')
            ->find($id)
        ;

        if (!$book) {
            throw new NotFoundException('Book not found');
        }

        return $this->render('show.phtml', [
            'book' => $book
        ]);
    }

    public function pdfExportAction()
    {
        $this->container->get('pdf_export')->export();
    }
}