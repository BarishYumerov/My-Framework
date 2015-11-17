<?php

namespace RedDevil\Models;

class user
{
	const COL_ID = 'id';
	const COL_USERNAME = 'username';
	const COL_EMAIL = 'email';
	const COL_TELEPHONE = 'telephone';
	const COL_ADDRESS = 'address';

	private $id;
	private $username;
	private $email;
	private $telephone;
	private $address;

	public function __construct($username, $email, $telephone, $address, $id = null)
	{
		$this->setId($id);
		$this->setUsername($username);
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