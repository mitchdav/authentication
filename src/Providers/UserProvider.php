<?php

namespace App\Auth;

use Jose\Loader;

class UserProvider
{
	public static function createFromToken($token)
	{
		$jws = (new Loader())->load($token);

		$user = new User();

		$user->setToken($token)
		     ->setPayload((array)$jws->getPayload())
		     ->setId($jws->getClaim('id'))
		     ->setUsername($jws->getClaim('username'));

		return $user;
	}
}