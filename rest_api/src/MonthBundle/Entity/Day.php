<?php

namespace MonthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Day
 *
 * @ORM\Table(name="day")
 * @ORM\Entity(repositoryClass="MonthBundle\Repository\DayRepository")
 */
class Day
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="day", type="date", unique=true)
     * @Assert\NotBlank()
     */
    private $day;

    /**
     * @var int
     *
     * @ORM\Column(name="single_price", type="integer")
     * @Assert\NotBlank()
     */
    private $singlePrice;

    /**
     * @var int
     *
     * @ORM\Column(name="single_available", type="smallint")
     * @Assert\NotBlank()
     */
    private $singleAvailable;

    /**
     * @var int
     *
     * @ORM\Column(name="double_price", type="integer")
     * @Assert\NotBlank()
     */
    private $doublePrice;

    /**
     * @var int
     *
     * @ORM\Column(name="double_available", type="smallint")
     * @Assert\NotBlank()
     */
    private $doubleAvailable;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
   * Set id
   *
   * @return int
   */
    public function setId($id)
    {
       $this->id = $id;
       return $this;
    }

    /**
     * Set day
     *
     * @param \DateTime $day
     *
     * @return Day
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return \DateTime
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set singlePrice
     *
     * @param integer $singlePrice
     *
     * @return Day
     */
    public function setSinglePrice($singlePrice)
    {
        $this->singlePrice = $singlePrice;

        return $this;
    }

    /**
     * Get singlePrice
     *
     * @return int
     */
    public function getSinglePrice()
    {
        return $this->singlePrice;
    }

    /**
     * Set singleAvailable
     *
     * @param integer $singleAvailable
     *
     * @return Day
     */
    public function setSingleAvailable($singleAvailable)
    {
        $this->singleAvailable = $singleAvailable;

        return $this;
    }

    /**
     * Get singleAvailable
     *
     * @return int
     */
    public function getSingleAvailable()
    {
        return $this->singleAvailable;
    }

    /**
     * Set doublePrice
     *
     * @param integer $doublePrice
     *
     * @return Day
     */
    public function setDoublePrice($doublePrice)
    {
        $this->doublePrice = $doublePrice;

        return $this;
    }

    /**
     * Get doublePrice
     *
     * @return int
     */
    public function getDoublePrice()
    {
        return $this->doublePrice;
    }

    /**
     * Set doubleAvailable
     *
     * @param integer $doubleAvailable
     *
     * @return Day
     */
    public function setDoubleAvailable($doubleAvailable)
    {
        $this->doubleAvailable = $doubleAvailable;

        return $this;
    }

    /**
     * Get doubleAvailable
     *
     * @return int
     */
    public function getDoubleAvailable()
    {
        return $this->doubleAvailable;
    }

    public function update($newDay){

      $this->singlePrice = $newDay->getSinglePrice();
      $this->singleAvailable = $newDay->getSingleAvailable();
      $this->doublePrice = $newDay->getDoublePrice();
      $this->doubleAvailable = $newDay->getDoubleAvailable();

    }

    public static function createNewDay($d){
      if(!$d['day']){
       return null;
      }
      $day = new Day();
      $day->setDay(date_create($d['day']));
      $day->setSinglePrice($d['single']['price']);
      $day->setSingleAvailable($d['single']['available']);
      $day->setDoublePrice($d['double']['price']);
      $day->setDoubleAvailable($d['double']['available']);
      if($d['id']){
        $day->setId($d['id']);
      };
      return $day;
    }

    public static function makeDays($days){
      return array_map( array(__CLASS__ ,'createNewDay'), $days);
    }

}
