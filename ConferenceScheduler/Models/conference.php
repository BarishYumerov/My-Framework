<?php

namespace ConferenceScheduler\Models;

class Conference
{
	const COL_ID = 'id';
	const COL_NAME = 'Name';
	const COL_VENUEID = 'VenueId';
	const COL_START = 'Start';
	const COL_END = 'End';
	const COL_OWNERID = 'OwnerId';

	private $id;
	private $Name;
	private $VenueId;
	private $Start;
	private $End;
	private $OwnerId;

	public function __construct($Name, $VenueId, $Start, $End, $OwnerId, $id = null)
	{
		$this->setId($id);
		$this->setName($Name);
		$this->setVenueId($VenueId);
		$this->setStart($Start);
		$this->setEnd($End);
		$this->setOwnerId($OwnerId);
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
	public function getVenueId()
	{
		return $this->VenueId;
	}

	/**
	* @param $VenueId
	* @return $this
	*/
	public function setVenueId($VenueId)
	{
		$this->VenueId = $VenueId;
		
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
	public function getOwnerId()
	{
		return $this->OwnerId;
	}

	/**
	* @param $OwnerId
	* @return $this
	*/
	public function setOwnerId($OwnerId)
	{
		$this->OwnerId = $OwnerId;
		
		return $this;
	}

}