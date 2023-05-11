<?php

namespace  Bisix21\src\Models;

use Illuminate\Database\Eloquent\Model;

class UrlShort extends Model
{
	protected $table = "urls_shorts";
	public string $code;
	public string $link;
}