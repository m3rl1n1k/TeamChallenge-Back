<?php

namespace App\Enum;

enum OrderStatusEnum: int
{
	const PREPARE = 1;
	const CONFIRM = 2;
	const DELIVERY = 3;
	const CANCEL = 4;
	const FINISH = 5;
}