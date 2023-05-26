<?php

namespace Bisix21\src\Models;

use Illuminate\Database\Eloquent\Model;

class UrlShort extends Model
{
	protected $table = "urls_shorts";

	public function getUrlByCode($code)
	{
		$res = UrlShort::query()->where("code", '=', $code)->first();
		if ($res !== null) {
			$res = json_decode($res);
		}
		return $res;
	}
}