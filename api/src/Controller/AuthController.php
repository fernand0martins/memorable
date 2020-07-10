<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends AbstractController
{
    /** @var UserRepository $userRepository */
    private $usersRepository;

    /**
     * AuthController Constructor
     *
     * @param UserRepository $usersRepository
     */
    public function __construct(UserRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    /**
     * Register new user
     * @param Request $request
     *
     * @return Response
     */
    public function register(Request $request)
    {
        $newUserData['username']    = $request->get('username');
        $newUserData['password'] = $request->get('password');

        $user = $this->usersRepository->createNewUser($newUserData);

        return new Response(sprintf('User %s successfully created', $user->getUsername()));
    }

}
