<?php

namespace App\Controller\Auth;


use App\Model\User\UseCase\Reset\Request\Command;
use App\ReadModel\User\UserFetcher;
use App\Model\User\UseCase\Reset\Request\Form;
use App\Model\User\UseCase\Reset\Reset\Handler as ResetHandler;
use App\Model\User\UseCase\Reset\Reset\Command as ResetCommand;
use App\Model\User\UseCase\Reset\Reset\Form as ResetForm;
use App\Model\User\UseCase\Reset\Request\Handler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;

class ResetController extends AbstractController
{

    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("/reset", name="auth.reset")
     * @param Request $request
     * @param Handler $handler
     * @return Response
     */
    public function request(Request $request, Handler $handler): Response
    {
        $command = new Command();

        $form = $this->createForm(Form::class, $command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                $this->addFlash('success', 'Check your email.');
                return $this->redirectToRoute('home');
            } catch (\DomainException $exception) {
                $this->logger->error($exception->getMessage(), ['exception' => $exception]);
                $this->addFlash('error', $exception->getMessage());

            }
        }

        return $this->render('app/auth/reset/request.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/reset/{token}", name="auth.reset.reset")
     * @param string $token
     * @param Request $request
     * @param ResetHandler $handler
     * @param UserFetcher $users
     * @return Response
     */
    public function reset(string $token,Request $request, ResetHandler $handler, UserFetcher $users): Response
    {
        if (!$users->existsByResetToken($token)) {
            $this->addFlash('error', 'Incorrect or already confirmed token.');
            return $this->redirectToRoute('home');
        }

        $command = new ResetCommand($token);

        $form = $this->createForm(ResetForm::class, $command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                $this->addFlash('success', 'Password change');
                return $this->redirectToRoute('home');
            } catch (\DomainException $exception) {
                $this->logger->error($exception->getMessage(), ['exception' => $exception]);
                $this->addFlash('error', $exception->getMessage());

            }
        }
        return $this->render('app/auth/reset/reset.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
