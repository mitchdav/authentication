<?php

namespace Mitchdav\Authentication\Providers;

use Jose\Factory\CheckerManagerFactory;
use Jose\Loader;
use Mitchdav\Authentication\Checkers\IssuerChecker;
use Mitchdav\Authentication\User;

class UserProvider
{
	public static function createFromToken($token)
	{
		$checkerManager = CheckerManagerFactory::createClaimCheckerManager([
			'exp',
			'iat',
			'nbf',
			new IssuerChecker(config('microservices.authentication.issuers')),
		]);

		$jws = (new Loader())->load($token);

		$checkerManager->checkJWS($jws, 0);

		$user = new User();

		$user->setToken($token)
		     ->setPayload((array)$jws->getPayload())
		     ->setId($jws->getClaim('id'))
		     ->setUsername($jws->getClaim('username'));

		return $user;
	}
}