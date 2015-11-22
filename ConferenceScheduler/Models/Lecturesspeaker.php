<?php

namespace ConferenceScheduler\Models;

class Lecturesspeaker
{
	const COL_ID = 'id';
	const COL_LECTUREID = 'lectureId';
	const COL_SPEAKERID = 'speakerId';

	private $id;
	private $lectureId;
	private $speakerId;

	public function __construct($lectureId, $speakerId, $id = null)
	{
		$this->setId($id);
		$this->setLectureId($lectureId);
		$this->setSpeakerId($speakerId);
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
	public function getSpeakerId()
	{
		return $this->speakerId;
	}

	/**
	* @param $speakerId
	* @return $this
	*/
	public function setSpeakerId($speakerId)
	{
		$this->speakerId = $speakerId;
		
		return $this;
	}

}