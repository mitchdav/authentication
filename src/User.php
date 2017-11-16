<?php

namespace Mitchdav\Authentication;

class User implements \JsonSerializable
{
	/**
	 * @var string $token
	 */
	private $token;

	/**
	 * @var array $payload
	 */
	private $payload;

	/**
	 * @var string $id
	 */
	private $id;

	/**
	 * @var string $tenant
	 */
	private $tenant;

	/**
	 * @return string
	 */
	public function getToken()
	{
		return $this->token;
	}

	/**
	 * @param string $token
	 *
	 * @return User
	 */
	public function setToken($token)
	{
		$this->token = $token;

		return $this;
	}

	/**
	 * @return array
	 */
	public function getPayload()
	{
		return $this->payload;
	}

	/**
	 * @param array $payload
	 *
	 * @return User
	 */
	public function setPayload($payload)
	{
		$this->payload = $payload;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param string $id
	 *
	 * @return User
	 */
	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getTenant()
	{
		return $this->tenant;
	}

	/**
	 * @param string $tenant
	 *
	 * @return User
	 */
	public function setTenant($tenant)
	{
		$this->tenant = $tenant;

		return $this;
	}

	/**
	 * Specify data which should be serialized to JSON
	 * @link  http://php.net/manual/en/jsonserializable.jsonserialize.php
	 * @return mixed data which can be serialized by <b>json_encode</b>,
	 * which is a value of any type other than a resource.
	 * @since 5.4.0
	 */
	public function jsonSerialize()
	{
		return $this->getPayload();
	}
}
