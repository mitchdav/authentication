<?php

namespace App\Auth;

use Dingo\Api\Contract\Auth\Provider as DingoProvider;
use Dingo\Api\Routing\Route;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class DingoUserProvider implements DingoProvider
{
	public function authenticate(Request $request, Route $route)
	{
		$token  = NULL;
		$header = $request->header('Authorization');
		$query  = $request->input('token');

		if ($header && strpos($header, 'Bearer ') === 0) {
			$token = substr($header, strlen('Bearer '));
		} else if ($query !== NULL) {
			$token = $request->query('token');
		}

		if ($token) {
			return UserProvider::createFromToken($token);
		}

		throw new UnauthorizedHttpException(env('APP_NAME'));
	}
}