<?php

namespace Mitchdav\Authentication\Providers;

use Illuminate\Http\Request;

class AuthUserProvider
{
	public function authenticate(Request $request)
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

		return NULL;
	}
}