<?php

namespace Mitchdav\Authentication;

use Illuminate\Support\ServiceProvider;

class Provider extends ServiceProvider
{
	public function boot()
	{
		$this->publishes([
			__DIR__ . '/../config/authentication.php' => config_path('microservices/authentication.php'),
		], 'config');
	}

	public function register()
	{
		$this->mergeConfigFrom(__DIR__ . '/../config/authentication.php', 'authentication');
	}
}