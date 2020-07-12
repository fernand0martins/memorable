<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AuthController extends AbstractController
{
    /** @var UserRepository $userRepository */
    private UserRepository $usersRepository;

    /**
     * AuthController constructor.
     * @param UserRepository $usersRepository
     */
    public function __construct(UserRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    /**
     * Register new user
     * @param Request $request
     * @return Response
     */
    public function register(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['username']) || !isset($data['password'])) {
            return new Response('Missing required data.', 500);
        }

        $exists = $this->usersRepository->findOneBy(['username' => $data['username']]);

        if ($exists !== null) {
            return new Response('User already exists.', 409);
        }

        $this->usersRepository->createNewUser($data['username'], $data['password']);

        return new Response(sprintf('User %s successfully created', $data['username']));
    }
}
