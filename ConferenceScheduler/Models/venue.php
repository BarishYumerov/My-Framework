<?php

namespace RedDevil\Models;

class venue
{
	const COL_ID = 'id';
	const COL_NAME = 'Name';

	private $id;
	private $Name;

	public function __construct($Name, $id = null)
	{
		$this->setId($id);
		$this->setName($Name);
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
	public function getName()
	{
		return $this->Name;
	}

	/**
	* @param $Name
	* @return $this
	*/
	public function setName($Name)
	{
		$this->Name = $Name;
		
		return $this;
	}

}