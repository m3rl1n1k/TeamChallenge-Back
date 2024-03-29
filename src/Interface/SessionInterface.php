<?php

namespace App\Interface;

interface SessionInterface
{
public function getSession():array;
public function addToSession():void;
public function removeFromSession():void;
}