<?php

namespace App\Models;

use Carbon\Carbon;
use App\Exceptions\InvalidOutputProperty;

class Outputs
{
    /** @var int */
    private $id;

    /** @var string */
    private $rule = '';

    /** @var int|null */
    private $daily_app_limit;

    public function __get($property) 
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
        throw new InvalidOutputProperty($property);
    }    

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        } else {
            throw new InvalidOutputProperty($property);
        }
    }
}
