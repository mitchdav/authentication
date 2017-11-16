<?php

namespace Mitchdav\Authentication\Checkers;

use Jose\Checker\IssuerChecker as BaseIssuerChecker;

class IssuerChecker extends BaseIssuerChecker
{
	/**
	 * @var array $allowedIssuers
	 */
	private $allowedIssuers;

	public function __construct(array $allowedIssuers)
	{
		$this->allowedIssuers = $allowedIssuers;
	}

	protected function isIssuerAllowed($issuer)
	{
		if (count($this->allowedIssuers) == 0) {
			return TRUE;
		}

		$found = FALSE;

		foreach ($this->allowedIssuers as $allowedIssuer) {
			if (starts_with($issuer, $allowedIssuer)) {
				$found = TRUE;

				break;
			}
		}

		return $found;
	}
}