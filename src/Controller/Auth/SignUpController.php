<?php

namespace App\Controller\Auth;

use App\Model\User\UseCase\SignUp\Request\Handler;
use App\Model\User\UseCase\SignUp\Confirm\Handler as ConfirmHandler;
use App\Model\User\UseCase\SignUp\Request\Command;
use App\Model\User\UseCase\SignUp\Confirm\Command as SingnUpCommand;
use App\Model\User\UseCase\SignUp\Request\Form;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;

class SignUpController extends AbstractController
{

    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("/signup", name="auth.signup")
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

        return $this->render('app/auth/signup.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/signup/{token}", name="auth.signup.confirm")
     * @param string $token
     * @param ConfirmHandler $handler
     * @return Response
     */
    public function confirm(string $token,ConfirmHandler $handler): Response
    {
        $command = new SingnUpCommand($token);
        try {
            $handler->handle($command);
            $this->addFlash('success', 'Email is successfully confirmed.');
        } catch (\DomainException $exception) {
            $this->logger->error($exception->getMessage(), ['exception' => $exception]);
            $this->addFlash('error', $exception->getMessage());
        }

        return $this->redirectToRoute('home');
    }
}
