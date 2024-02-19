<?php

namespace App\Controller\Blog;

use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
    #[Route('/', name: 'app_post_index', methods: ['GET'])]
    public function index(PostRepository $postRepository, PaginatorInterface $paginatorInterface, Request $request): Response
    {
        $data = $postRepository->findPublished();
        $posts = $paginatorInterface->paginate(
            $data,
            $request->query->getInt('page', 1),
            9
        );
        return $this->render('pages/post/index.html.twig', [
            'posts' => $posts
        ]);
    }
}
