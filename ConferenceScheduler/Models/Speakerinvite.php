<?php

namespace ConferenceScheduler\Models;

class Speakerinvite
{
	const COL_ID = 'id';
	const COL_USERID = 'userId';
	const COL_LECTUREID = 'lectureId';

	private $id;
	private $userId;
	private $lectureId;

	public function __construct($userId, $lectureId, $id = null)
	{
		$this->setId($id);
		$this->setUserId($userId);
		$this->setLectureId($lectureId);
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
	public function getLectureId()
	{
		return $this->lectureId;
	}

	/**
	* @param $lectureId
	* @return $this
	*/
	public function setLectureId($lectureId)
	{
		$this->lectureId = $lectureId;
		
		return $this;
	}

}