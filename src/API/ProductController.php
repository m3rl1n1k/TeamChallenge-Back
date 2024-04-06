<?php

namespace App\API;

use App\Core\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends AbstractController
{

    public function index(): Response
    {
        return $this->json('');
    }

    public function show($show): Response
    {
        //get variable with name from {variable} from address show/{variable}
        return $this->json($show);
    }

    public function new($request): Response
    {
        //get content from request body $request
        return $this->json($request);
    }
}