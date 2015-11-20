<?php

namespace ConferenceScheduler\Models;

class User
{
	const COL_ID = 'id';
	const COL_USERNAME = 'username';
	const COL_PASSWORD = 'password';
	const COL_EMAIL = 'email';
	const COL_TELEPHONE = 'telephone';
	const COL_ADDRESS = 'address';

	private $id;
	private $username;
	private $password;
	private $email;
	private $telephone;
	private $address;

	public function __construct($username, $password, $email, $telephone, $address, $id = null)
	{
		$this->setId($id);
		$this->setUsername($username);
		$this->setPassword($password);
		$this->setEmail($email);
		$this->setTelephone($telephone);
		$this->setAddress($address);
	}

	/**
	* @return mixed
	*/
	public function getId()
	{
		return $this->id;
	}

	/**
	* @param $id
	* @return $this
	*/
	public function setId($id)
	{
		$this->id = $id;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getUsername()
	{
		return $this->username;
	}

	/**
	* @param $username
	* @return $this
	*/
	public function setUsername($username)
	{
		$this->username = $username;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getPassword()
	{
		return $this->password;
	}

	/**
	* @param $password
	* @return $this
	*/
	public function setPassword($password)
	{
		$this->password = $password;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getEmail()
	{
		return $this->email;
	}

	/**
	* @param $email
	* @return $this
	*/
	public function setEmail($email)
	{
		$this->email = $email;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getTelephone()
	{
		return $this->telephone;
	}

	/**
	* @param $telephone
	* @return $this
	*/
	public function setTelephone($telephone)
	{
		$this->telephone = $telephone;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getAddress()
	{
		return $this->address;
	}

	/**
	* @param $address
	* @return $this
	*/
	public function setAddress($address)
	{
		$this->address = $address;
		
		return $this;
	}

}