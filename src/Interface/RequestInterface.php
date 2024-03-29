<?php

namespace App\Interface;

interface RequestInterface
{
public function getUrl():string;
public function getMethod():string;

}