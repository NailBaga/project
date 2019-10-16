<?php
namespace App\Controller\Blog\Author;


use App\Model\Blog\Entity\Author\Author;
use App\Model\Blog\Entity\Author\AuthorRepository;
use App\Model\Blog\UseCase\Author\Create\Command;
use App\Model\Blog\UseCase\Author\Edit\Command as EditCommand;
use App\Model\Blog\UseCase\Author\Create\Form;
use App\Model\Blog\UseCase\Author\Create\Handler;
use App\Model\Blog\UseCase\Author\Edit\Handler as EditHandler;
use App\Model\User\Entity\User\User;
use App\ReadModel\Blog\Author\AuthorFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class AuthorController extends AbstractController
{
    /**
     * @Route("authors", name="authors")
     * @param AuthorFetcher $fetcher
     * @return Response
     */
    public function index(AuthorFetcher $fetcher): Response
    {
        $authors = $fetcher->findAll();

        return $this->render('app/blog/author/index.html.twig', [
            'authors' => $authors,
        ]);
    }

    /**
     * @Route("/author/create/{id}", name="author_create")
     * @param User $user
     * @param Request $request
     * @param Handler $handler
     * @return Response
     */
    public function create(User $user, Request $request, Handler $handler): Response
    {
        $command = new Command($user->getId()->getValue());
        $command->firstName = $user->getName()->getFirst();
        $command->lastName = $user->getName()->getLast();

        $form = $this->createForm(Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                $this->addFlash('success', 'Author add');
                return $this->redirectToRoute('home');
            } catch (\DomainException $exception) {
                $this->addFlash('error', $exception->getMessage());
            }
        }

        return $this->render('app/blog/author/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}