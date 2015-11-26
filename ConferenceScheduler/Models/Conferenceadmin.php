<?php

namespace ConferenceScheduler\Models;

class Conferenceadmin
{
	const COL_ID = 'id';
	const COL_USERID = 'userId';
	const COL_CONFERENCEID = 'conferenceId';

	private $id;
	private $userId;
	private $conferenceId;

	public function __construct($userId, $conferenceId, $id = null)
	{
		$this->setId($id);
		$this->setUserId($userId);
		$this->setConferenceId($conferenceId);
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
	public function getConferenceId()
	{
		return $this->conferenceId;
	}

	/**
	* @param $conferenceId
	* @return $this
	*/
	public function setConferenceId($conferenceId)
	{
		$this->conferenceId = $conferenceId;
		
		return $this;
	}

}