<?php

namespace ConferenceScheduler\Models;

class Lecture
{
	const COL_ID = 'id';
	const COL_NAME = 'Name';
	const COL_START = 'Start';
	const COL_END = 'End';
	const COL_HALLID = 'hallId';
	const COL_VENUEID = 'venueId';
	const COL_CONFERENCEID = 'conferenceId';

	private $id;
	private $Name;
	private $Start;
	private $End;
	private $hallId;
	private $venueId;
	private $conferenceId;

	public function __construct($Name, $Start, $End, $hallId, $venueId, $conferenceId, $id = null)
	{
		$this->setId($id);
		$this->setName($Name);
		$this->setStart($Start);
		$this->setEnd($End);
		$this->setHallId($hallId);
		$this->setVenueId($venueId);
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


	/**
	* @return mixed
	*/
	public function getStart()
	{
		return $this->Start;
	}

	/**
	* @param $Start
	* @return $this
	*/
	public function setStart($Start)
	{
		$this->Start = $Start;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getEnd()
	{
		return $this->End;
	}

	/**
	* @param $End
	* @return $this
	*/
	public function setEnd($End)
	{
		$this->End = $End;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getHallId()
	{
		return $this->hallId;
	}

	/**
	* @param $hallId
	* @return $this
	*/
	public function setHallId($hallId)
	{
		$this->hallId = $hallId;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getVenueId()
	{
		return $this->venueId;
	}

	/**
	* @param $venueId
	* @return $this
	*/
	public function setVenueId($venueId)
	{
		$this->venueId = $venueId;
		
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