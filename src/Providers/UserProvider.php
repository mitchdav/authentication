<?php

namespace Mitchdav\Authentication\Providers;

use Jose\Factory\CheckerManagerFactory;
use Jose\Factory\JWKFactory;
use Jose\JWTLoader;
use Jose\Loader;
use Jose\Verifier;
use Mitchdav\Authentication\Checkers\IssuerChecker;
use Mitchdav\Authentication\User;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserProvider
{
	public static function createFromToken($token)
	{
		$alg     = 'HS512';
		$key     = config('microservices.authentication.key');
		$issuers = config('microservices.authentication.issuers');

		$checkerManager = CheckerManagerFactory::createClaimCheckerManager([
			'exp',
			'iat',
			'nbf',
			new IssuerChecker($issuers),
		]);

		$verifier = Verifier::createVerifier([
			$alg,
		]);

		$jwk = JWKFactory::createFromValues([
			'kty' => 'oct',
			'k'   => $key,
		]);

		$jws = (new Loader())->load($token);

		$jwtLoader = new JWTLoader($checkerManager, $verifier);

		try {
			$jwtLoader->verify($jws, $jwk);
		} catch (\Exception $exception) {
			throw new HttpException(401, $exception->getMessage());
		}

		$user = new User();

		$user->setToken($token)
		     ->setPayload((array)$jws->getPayload())
		     ->setId($jws->getClaim('sub'))
		     ->setTenant($jws->getClaim('tenant'));

		return $user;
	}
}