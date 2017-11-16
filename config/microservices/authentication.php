<?php

return [
	/**
	 * The authorized token issuers (leave empty to accept all issuers, though this is not recommended).
	 *
	 * Example:
	 * 'http://example.com',
	 */
	'issuers' => [

	],

	/**
	 * The JWT key used to verify the signature.
	 */
	'key'     => env('JWT_KEY', NULL),
];