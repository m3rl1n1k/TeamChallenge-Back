<?php

namespace App\API;

use App\Core\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends AbstractController
{
    private array $data = [
        9474475 => [
            "art" => 9474475,
            "name" => "snickers",
            "color" => "white",
            "brand" => "nike",
            "model" => "Air max",
            "price" => 199,
            "genre" => "man",
            "description" => "Some description about product",
            "image" => "path to image",
            "size" => [
                "40" => true,
                "41" => true,
                "42" => false
            ]
        ],
        9474474 => [
            "art" => 9474476,
            "name" => "snickers",
            "color" => "gray",
            "brand" => "nike",
            "model" => "Air max",
            "price" => 199,
            "genre" => "man",
            "description" => "Some description about product",
            "image" => "path to image",
            "size" => [
                "40" => true,
                "41" => true,
                "42" => false
            ]
        ]
    ];

    public function index(): Response
    {
        return $this->json($this->data);
    }

    public function show($show): Response
    {
        //get variable with name from {variable} from address show/{variable}
        $product = $this->data[$show];
        return $this->json($product);
    }

    public function new($request): Response
    {
        //get content from request body $request
        $this->data[]=$request;
        return $this->json("Product successfully added!");
    }

}