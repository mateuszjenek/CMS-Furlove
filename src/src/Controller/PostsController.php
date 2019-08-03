<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PostsController extends AbstractController
{
    /**
     * @Route("/posts", name="posts")
     */
    public function index(Request $request)
    {
        $currentPage = 1;
        $limit = 5;

        if ($request->get('page') != null) {
            $currentPage = $request->get('page');
        }
        /* @var Paginator $posts */
        $posts = $this->getDoctrine()->getRepository(Post::class)->getAllPosts($currentPage, $limit);

        $maxPages = ceil($posts->count() / $limit);

        return $this->render('posts/index.html.twig', [
            'posts' => $posts,
            'currentPage' => $currentPage,
            'maxPages' => $maxPages,
        ]);
    }

    /**
     * @Route("/posts/{id}", name="post_detail")
     */
    public function detail($id) {

        $post = $this->getDoctrine()->getRepository(Post::class)->find($id);

        return $this->render('posts/post.html.twig', [
            'post' => $post,
        ]);
    }
}
