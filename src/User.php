<?php

namespace Mitchdav\Authentication;

class User
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
	 * @var string $username
	 */
	private $username;

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
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * @param string $username
	 *
	 * @return User
	 */
	public function setUsername($username)
	{
		$this->username = $username;

		return $this;
	}
}
