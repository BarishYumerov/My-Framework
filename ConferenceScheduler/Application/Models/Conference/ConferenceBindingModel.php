<?php
declare(strict_types=1);
namespace ConferenceScheduler\Application\Models\Conference;

use ConferenceScheduler\Application\Models\BaseBindingModel;

use ConferenceScheduler\Core\HttpContext\HttpContext;
use ConferenceScheduler\Models\Conference;

class ConferenceBindingModel extends BaseBindingModel
{
    private $id;
    private $startDate;
    private $endDate;
    private $title;
    private $venueId;

    public function __construct(Conference $conference = null){
        if(!$conference){
            $context = HttpContext::getInstance();
            $this->setStartDate($context->post('startDate'));
            $this->setEndDate($context->post('endDate'));
            $this->setTitle($context->post('title'));
            $this->setVenueId($context->post('venueId', 'int'));
        }
        else{
            $this->venueId = intval($conference->getVenueId());
            $this->endDate = $conference->getEnd();
            $this->startDate = $conference->getStart();
            $this->title = $conference->getName();
            $this->id = $conference->getId();
        }
    }

    /**
     * @return mixed
     */
    public function getVenueId() : int
    {
        return intval($this->venueId);
    }

    /**
     * @param mixed $venueId
     */
    public function setVenueId(int $venueId)
    {
        $this->venueId = $venueId;
    }

    /**
     * @return mixed
     */
    public function getStartDate() : string
    {
        return $this->startDate;
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate(string $startDate)
    {
        if(strtotime($startDate) < time()){
            $this->errors[] = 'Start date must be tomorrow or later!';
        }
        $this->startDate = $startDate;
    }

    /**
     * @return mixed
     */
    public function getEndDate() : string
    {
        return $this->endDate;
    }

    /**
     * @param mixed $endDate
     */
    public function setEndDate(string $endDate)
    {
        if (strtotime($this->startDate) > strtotime($endDate)){
            $this->errors[] = 'End date must be later than start date';
        }
        $this->endDate = $endDate;
    }

    /**
     * @return mixed
     */
    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle(string $title)
    {
        if(count($title) == 0){
            $this->errors[] = 'Title length must be grater than 0!';
        }
        $this->title = $title;
    }

    public function getId() : int{
        return intval($this->id);
    }
}