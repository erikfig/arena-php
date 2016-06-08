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

    public function setMin(int $min)
    {
        $this->min = $min;
        return $this;
    }

    public function setMax(int $max)
    {
        $this->max = $max;
        return $this;
    }

    public function setTotal(int $total)
    {
        $this->total = $total;
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

    public function checkMinMax(string $value)
    {
        if ($this->fighter->$value > $this->max) {
            return false;
        }

        if ($this->fighter->$value < $this->min) {
            return false;
        }

        return true;
    }
}
