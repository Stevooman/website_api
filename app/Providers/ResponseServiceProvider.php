<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\ResponseFactory;

class ResponseServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot(ResponseFactory $factory)
	{
		$factory->macro('apiJson', function ($data = null) use ($factory) {
			$format = [
				'code' => http_response_code(),
				'data' => $data
			];

			return $factory->make($format);
		});
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}
}