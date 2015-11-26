<?php

namespace ConferenceScheduler\Core\ORM;

class DbContext
{
private $conferenceadminsRepository;
	private $conferencesRepository;
	private $hallsRepository;
	private $lecturesRepository;
	private $lecturesspeakersRepository;
	private $lecturesusersRepository;
	private $rolesRepository;
	private $speakerinvitesRepository;
	private $usersRepository;
	private $usersrolesRepository;
	private $venuesRepository;

private $repositories = [];

public function __construct()
    {
        $this->conferenceadminsRepository = \ConferenceScheduler\Repositories\ConferenceadminsRepository::create();
		$this->conferencesRepository = \ConferenceScheduler\Repositories\ConferencesRepository::create();
		$this->hallsRepository = \ConferenceScheduler\Repositories\HallsRepository::create();
		$this->lecturesRepository = \ConferenceScheduler\Repositories\LecturesRepository::create();
		$this->lecturesspeakersRepository = \ConferenceScheduler\Repositories\LecturesspeakersRepository::create();
		$this->lecturesusersRepository = \ConferenceScheduler\Repositories\LecturesusersRepository::create();
		$this->rolesRepository = \ConferenceScheduler\Repositories\RolesRepository::create();
		$this->speakerinvitesRepository = \ConferenceScheduler\Repositories\SpeakerinvitesRepository::create();
		$this->usersRepository = \ConferenceScheduler\Repositories\UsersRepository::create();
		$this->usersrolesRepository = \ConferenceScheduler\Repositories\UsersrolesRepository::create();
		$this->venuesRepository = \ConferenceScheduler\Repositories\VenuesRepository::create();

        $this->repositories[] = $this->conferenceadminsRepository;
		$this->repositories[] = $this->conferencesRepository;
		$this->repositories[] = $this->hallsRepository;
		$this->repositories[] = $this->lecturesRepository;
		$this->repositories[] = $this->lecturesspeakersRepository;
		$this->repositories[] = $this->lecturesusersRepository;
		$this->repositories[] = $this->rolesRepository;
		$this->repositories[] = $this->speakerinvitesRepository;
		$this->repositories[] = $this->usersRepository;
		$this->repositories[] = $this->usersrolesRepository;
		$this->repositories[] = $this->venuesRepository;
    }

        /**
     * @return \ConferenceScheduler\Repositories\ConferenceadminsRepository
     */
    public function getConferenceadminsRepository()
    {
        return $this->conferenceadminsRepository;
    }

    /**
     * @return \ConferenceScheduler\Repositories\ConferencesRepository
     */
    public function getConferencesRepository()
    {
        return $this->conferencesRepository;
    }

    /**
     * @return \ConferenceScheduler\Repositories\HallsRepository
     */
    public function getHallsRepository()
    {
        return $this->hallsRepository;
    }

    /**
     * @return \ConferenceScheduler\Repositories\LecturesRepository
     */
    public function getLecturesRepository()
    {
        return $this->lecturesRepository;
    }

    /**
     * @return \ConferenceScheduler\Repositories\LecturesspeakersRepository
     */
    public function getLecturesspeakersRepository()
    {
        return $this->lecturesspeakersRepository;
    }

    /**
     * @return \ConferenceScheduler\Repositories\LecturesusersRepository
     */
    public function getLecturesusersRepository()
    {
        return $this->lecturesusersRepository;
    }

    /**
     * @return \ConferenceScheduler\Repositories\RolesRepository
     */
    public function getRolesRepository()
    {
        return $this->rolesRepository;
    }

    /**
     * @return \ConferenceScheduler\Repositories\SpeakerinvitesRepository
     */
    public function getSpeakerinvitesRepository()
    {
        return $this->speakerinvitesRepository;
    }

    /**
     * @return \ConferenceScheduler\Repositories\UsersRepository
     */
    public function getUsersRepository()
    {
        return $this->usersRepository;
    }

    /**
     * @return \ConferenceScheduler\Repositories\UsersrolesRepository
     */
    public function getUsersrolesRepository()
    {
        return $this->usersrolesRepository;
    }

    /**
     * @return \ConferenceScheduler\Repositories\VenuesRepository
     */
    public function getVenuesRepository()
    {
        return $this->venuesRepository;
    }

        /**
     * @param mixed $conferenceadminsRepository
     * @return $this
     */
    public function setConferenceadminsRepository($conferenceadminsRepository)
    {
        $this->conferenceadminsRepository = $conferenceadminsRepository;
        return $this;
    }

    /**
     * @param mixed $conferencesRepository
     * @return $this
     */
    public function setConferencesRepository($conferencesRepository)
    {
        $this->conferencesRepository = $conferencesRepository;
        return $this;
    }

    /**
     * @param mixed $hallsRepository
     * @return $this
     */
    public function setHallsRepository($hallsRepository)
    {
        $this->hallsRepository = $hallsRepository;
        return $this;
    }

    /**
     * @param mixed $lecturesRepository
     * @return $this
     */
    public function setLecturesRepository($lecturesRepository)
    {
        $this->lecturesRepository = $lecturesRepository;
        return $this;
    }

    /**
     * @param mixed $lecturesspeakersRepository
     * @return $this
     */
    public function setLecturesspeakersRepository($lecturesspeakersRepository)
    {
        $this->lecturesspeakersRepository = $lecturesspeakersRepository;
        return $this;
    }

    /**
     * @param mixed $lecturesusersRepository
     * @return $this
     */
    public function setLecturesusersRepository($lecturesusersRepository)
    {
        $this->lecturesusersRepository = $lecturesusersRepository;
        return $this;
    }

    /**
     * @param mixed $rolesRepository
     * @return $this
     */
    public function setRolesRepository($rolesRepository)
    {
        $this->rolesRepository = $rolesRepository;
        return $this;
    }

    /**
     * @param mixed $speakerinvitesRepository
     * @return $this
     */
    public function setSpeakerinvitesRepository($speakerinvitesRepository)
    {
        $this->speakerinvitesRepository = $speakerinvitesRepository;
        return $this;
    }

    /**
     * @param mixed $usersRepository
     * @return $this
     */
    public function setUsersRepository($usersRepository)
    {
        $this->usersRepository = $usersRepository;
        return $this;
    }

    /**
     * @param mixed $usersrolesRepository
     * @return $this
     */
    public function setUsersrolesRepository($usersrolesRepository)
    {
        $this->usersrolesRepository = $usersrolesRepository;
        return $this;
    }

    /**
     * @param mixed $venuesRepository
     * @return $this
     */
    public function setVenuesRepository($venuesRepository)
    {
        $this->venuesRepository = $venuesRepository;
        return $this;
    }

public function saveChanges()
{
    foreach ($this->repositories as $repository) {
        $repositoryName = get_class($repository);
        $repositoryName::save();
    }
}
}