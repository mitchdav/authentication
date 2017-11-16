<?php

namespace Mitchdav\Authentication\Providers;

use Jose\Factory\CheckerManagerFactory;
use Jose\Factory\JWKFactory;
use Jose\Loader;
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

		$algs = [
			$alg,
		];

		$checkerManager = CheckerManagerFactory::createClaimCheckerManager([
			'exp',
			'iat',
			'nbf',
			new IssuerChecker($issuers),
		]);

		$jwk = JWKFactory::createFromValues([
			'kty' => 'oct',
			'k'   => $key,
		]);

		$loader = new Loader();

		try {
			$jws = $loader->loadAndVerifySignatureUsingKey($token, $jwk, $algs, $signatureIndex);

			$checkerManager->checkJWS($jws, $signatureIndex);
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