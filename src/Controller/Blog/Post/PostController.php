<?php
namespace App\Controller\Blog\Post;

use App\Model\Blog\Entity\Post\Post;
use App\Model\Blog\UseCase\Post\Create\Command;
use App\Model\Blog\UseCase\Post\Create\Form;
use App\Model\Blog\UseCase\Post\Create\Handler;
use App\ReadModel\Blog\Post\PostFetcher;
use phpDocumentor\Reflection\DocBlock\Tags\Author;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use App\Model\Blog\UseCase\Post\Edit\Handler as EditHandler;
use App\Model\Blog\UseCase\Post\Edit\Command as EditCommand;
use App\Model\Blog\UseCase\Post\Edit\Form as EditForm;

class PostController extends AbstractController
{
    /**
     * @Route("/post/create", name="post_create")
     * @param Request $request
     * @param Handler $handler
     * @param TokenStorageInterface $tokenStorage
     * @return Response
     */
    public function create(Request $request, Handler $handler,  TokenStorageInterface $tokenStorage): Response
    {
        $command = new Command($tokenStorage->getToken()->getUser());

        $form = $this->createForm(Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                $this->addFlash('success', 'Post add');
                return $this->redirectToRoute('home');
            } catch (\DomainException $exception) {
                $this->addFlash('error', $exception->getMessage());
            }
        }

        return $this->render('app/blog/post/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/post/edit/{id}", name="post_edit")
     * @param Post $post
     * @param Request $request
     * @param EditHandler $handler
     * @return Response
     */

    public function edit(Post $post, Request $request, EditHandler $handler): Response
    {
        $command = EditCommand::fromPost($post);

        $form = $this->createForm(EditForm::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                $this->addFlash('success', 'Post is edit');
                return $this->redirectToRoute('home');
            } catch (\DomainException $exception) {
                $this->addFlash('error', $exception->getMessage());
            }
        }

        return $this->render('app/blog/post/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/post", name="post_show")
     * @param PostFetcher $fetcher
     * @return Response
     */
    public function index(PostFetcher $fetcher): Response
    {
        $posts = $fetcher->all();

        return $this->render('app/blog/post/index.html.twig', compact('posts'));
    }
}