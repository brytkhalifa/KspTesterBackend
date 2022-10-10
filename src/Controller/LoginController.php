<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController
{

    #[Route('/blog', name: 'blog_list', methods: ['GET'])]    
    /**
     * login
     *
     * @return Response
     */
    public function login(): Response
    {
        $number = random_int(0, 100);
        return  new Response(json_encode(['name' => 'bright']), 200, ['Content-Type' =>  'application/json']);
    }
}