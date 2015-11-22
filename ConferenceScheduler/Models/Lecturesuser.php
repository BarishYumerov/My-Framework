<?php

namespace ConferenceScheduler\Models;

class Lecturesuser
{
	const COL_ID = 'id';
	const COL_LECTUREID = 'lectureId';
	const COL_USERID = 'userId';

	private $id;
	private $lectureId;
	private $userId;

	public function __construct($lectureId, $userId, $id = null)
	{
		$this->setId($id);
		$this->setLectureId($lectureId);
		$this->setUserId($userId);
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

}