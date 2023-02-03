<?php

namespace App\Models;

use Carbon\Carbon;
use App\Exceptions\InvalidInputProperty;

class Inputs
{
    /** @var int */
    private $id;

    /** @var int */
    private $delivery;

    /** @var int */
    private $period_app_limit;

    /** @var Carbon */
    private $period_from;

    /** @var Carbon */
    private $period_to;

    /** @var int */
    private $remaining_apps;

    /** @var int */
    private $remaining_days;

    /** @var int */
    private $time_since_period_start;

    /** @var int */
    private $time_period_full;

    /** @var int */
    private $period_in_days;

    /** @var string */
    private $rule = '';

    /** @var int|null */
    private $daily_app_limit;

    public function __get($property) 
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        } 
        throw new InvalidInputProperty($property);
    }    

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        } else {
            throw new InvalidInputProperty($property);
        }
    }
}
