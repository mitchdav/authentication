<?php

namespace Mitchdav\Authentication;

use Dingo\Api\Auth\Auth as DingoManager;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Mitchdav\Authentication\Providers\AuthUserProvider;
use Mitchdav\Authentication\Providers\DingoUserProvider;
use Mitchdav\Authentication\Providers\UserProvider;

class Provider extends ServiceProvider
{
	public function boot()
	{
		$this->publishes([
			__DIR__ . '/../config/authentication.php' => config_path('microservices/authentication.php'),
		], 'config');

		// Laravel auth
		// Auth::user()
		// $request->user()

		/** @var AuthUserProvider $authUserProvider */
		$authUserProvider = $this->app[AuthUserProvider::class];

		/** @var AuthManager $authManager */
		$authManager = $this->app['auth'];

		$authManager->viaRequest('api', function ($request) use ($authUserProvider) {
			/** @var Request $request */

			return $authUserProvider->authenticate($request);
		});

		// Dingo auth
		// $this->user()

		/** @var DingoUserProvider $dingoUserProvider */
		$dingoUserProvider = $this->app[DingoUserProvider::class];

		/** @var DingoManager $dingoManager */
		$dingoManager = $this->app[DingoManager::class];

		$dingoManager->extend('jwt', function () use ($dingoUserProvider) {
			return $dingoUserProvider;
		});
	}

	public function register()
	{
		$this->mergeConfigFrom(__DIR__ . '/../config/authentication.php', 'authentication');

		$this->app->singleton(AuthUserProvider::class, function () {
			return new AuthUserProvider();
		});

		$this->app->singleton(DingoUserProvider::class, function () {
			return new DingoUserProvider();
		});

		$this->app->singleton(UserProvider::class, function () {
			return new UserProvider();
		});

		$this->app['router']->aliasMiddleware('authenticate', \Mitchdav\Authentication\Middleware\Authenticate::class);
	}
}