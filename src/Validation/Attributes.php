<?php

namespace WebDevBr\ArenaPHP\Validation;

use WebDevBr\ArenaPHP\Entity\Fighter;

class Attributes
{
    private $min;
    private $max;
    private $total;

    public function setFighter(Fighter $fighter)
    {
        $this->fighter = $fighter;
        return $this;
    }

    public function setMin($min)
    {
        if (!is_int($min)) {
            throw new \Exception("Minimum must be an integer.");
        }

        $this->min = (int) $min;
        return $this;
    }

    public function setMax($max)
    {
        if (!is_int($max)) {
            throw new \Exception("Maximum must be an integer.");
        }

        $this->max = (int) $max;
        return $this;
    }

    public function setTotal($total)
    {
        if (!is_int($total)) {
            throw new \Exception("Total must be an integer.");
        }

        $this->total = (int) $total;
        return $this;
    }

    public function checkTotal()
    {
        $total = 0;
        foreach ($this->fighter->attributes as $value) {
            $total += $this->fighter->$value;
        }

        if ($total > $this->total) {
            return false;
        }

        return true;
    }

    public function checkMinMax($value)
    {
        if (!is_string($value)) {
            throw new \Exception("Value must be a string.");
        }

        if ($this->fighter->$value > $this->max) {
            return false;
        }

        if ($this->fighter->$value < $this->min) {
            return false;
        }

        return true;
    }
}
