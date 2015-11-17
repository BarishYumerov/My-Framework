<?php

namespace RedDevil\Models;

class hall
{
	const COL_ID = 'id';
	const COL_NAME = 'Name';
	const COL_PLACES = 'places';
	const COL_VENUEID = 'venueId';

	private $id;
	private $Name;
	private $places;
	private $venueId;

	public function __construct($Name, $places, $venueId, $id = null)
	{
		$this->setId($id);
		$this->setName($Name);
		$this->setPlaces($places);
		$this->setVenueId($venueId);
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
	public function getPlaces()
	{
		return $this->places;
	}

	/**
	* @param $places
	* @return $this
	*/
	public function setPlaces($places)
	{
		$this->places = $places;
		
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

}