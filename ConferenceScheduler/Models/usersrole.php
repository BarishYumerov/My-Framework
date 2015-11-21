<?php

namespace ConferenceScheduler\Models;

class Usersrole
{
	const COL_USERID = 'userId';
	const COL_ROLEID = 'roleId';
	const COL_ID = 'id';

	private $userId;
	private $roleId;
	private $id;

	public function __construct($userId, $roleId, $id = null)
	{
		$this->setUserId($userId);
		$this->setRoleId($roleId);
		$this->setId($id);
	}

	/**
	* @return mixed
	*/
	public function getUserId()
	{
		return $this->userId;
	}

	/**
	* @param $userId
	* @return $this
	*/
	public function setUserId($userId)
	{
		$this->userId = $userId;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getRoleId()
	{
		return $this->roleId;
	}

	/**
	* @param $roleId
	* @return $this
	*/
	public function setRoleId($roleId)
	{
		$this->roleId = $roleId;
		
		return $this;
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

}