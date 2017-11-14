<?php

namespace Mitchdav\Authentication\Providers;

use Jose\Loader;
use Mitchdav\Authentication\User;

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