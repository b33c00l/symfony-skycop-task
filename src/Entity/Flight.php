<?php

namespace App\Entity;

class Flight
{
    /**
     * @var
     */
    private $country;

    /**
     * @var
     */
    private $status;

    /**
     * @var
     */
    private $details;

    /**
     * Flight constructor.
     * @param $country
     * @param $status
     * @param $details
     */
    public function __construct($country, $status, $details)
    {
        $this->country = $country;
        $this->status = $status;
        $this->details = $details;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getDetails()
    {
        return $this->details;
    }
}