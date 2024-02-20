<?php

namespace App\Controller\Blog;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityNotFoundException;
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
        try{
            $data = $postRepository->findPublished();
        } catch (EntityNotFoundException $ex){
            echo "Exception Found - " . $ex->getMessage() . "<br/>"; // change the message  with addflash for example !
        }
        return $this->render('pages/post/index.html.twig', ['posts' => $paginatorInterface->paginate( $data, $request->query->getInt('page', 1),9) ]);
    }

    #[Route('/article/{slug}',name:'app_post_show',methods:['GET'])]
    public function show( Post $post): Response
    {
        return $this->render('pages/post/show.html.twig',['post'=>$post]);
    }
}
