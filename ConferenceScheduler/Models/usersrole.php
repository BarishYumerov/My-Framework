<?php

namespace RedDevil\Models;

class usersrole
{
	const COL_USERID = 'userId';
	const COL_ROLEID = 'roleId';

	private $userId;
	private $roleId;

	public function __construct($userId, $roleId, $id = null)
	{
		$this->setUserId($userId);
		$this->setRoleId($roleId);
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

}