<?php

namespace WebDevBr\ArenaPHP\Entity;

class Fighter extends Entity
{
    protected $name;

    protected $strength;
    protected $agility;
    protected $constitution;
    protected $life;

    protected $attributes = ['strength', 'agility', 'constitution'];

    protected function setName($value)
    {
        $value = preg_replace("/[^[:alnum:][:space:]]/u", '', $value);
        $value = strtolower($value);
        $this->name = ucwords($value);
    }

    protected function setStrength($value)
    {
        $this->strength = (int)$value;
    }

    protected function setAgility($value)
    {
        $this->agility = (int)$value;
    }

    protected function setConstituition($value)
    {
        $this->constitution = (int)$value;
    }

    protected function getLife()
    {
        if ($this->life === null) {
            $this->life = ($this->strength + $this->constitution) / 2;
        }
        return $this->life = ceil($this->life);
    }

    public function toArray()
    {
        $data = [];
        $data['name'] = $this->name;

        foreach ($this->getAttributes() as $attribute) {
            $data[$attribute] = $this->$attribute;
        }

        return $data;
    }
}
