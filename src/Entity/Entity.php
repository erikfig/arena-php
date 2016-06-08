<?php

namespace WebDevBr\ArenaPHP\Entity;

abstract class Entity
{
    public function __get($name)
    {
        $method = 'get'.ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        if (isset($this->$name)) {
            return $this->$name;
        }
        return null;
    }

    public function __set($name, $value)
    {
        $method = 'set'.ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method($value);
        }

        $attributes = $this->getAttributes();

        if (isset($attributes[$name])) {
            $this->name = (int)$attributes[$name];
        }

        return $this->$name = $value;
    }

    public function getAttributes()
    {
        if (!isset($this->attributes) or !is_array($this->attributes)) {
            return [];
        }

        return $this->attributes;
    }
}
