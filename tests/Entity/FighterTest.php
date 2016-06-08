<?php

namespace WebDevBr\ArenaPHP\Entity;

class FighterTest extends \PHPUnit_Framework_TestCase
{
    private $entity;

    protected function setUp()
    {
        $this->entity = new Fighter;
    }

    public function testSetName()
    {
        $this->entity->name = 'erik figueiredo';
        $this->assertEquals('Erik Figueiredo', $this->entity->name);
    }

    public function testSetAttributes()
    {
        $this->entity->strength = 'dez';
        $this->entity->agility = '10dez';
        $this->entity->constitution = 10;

        $this->assertEquals(0, $this->entity->strength);
        $this->assertEquals(10, $this->entity->agility);
        $this->assertEquals(10, $this->entity->constitution);
    }

    public function testGetLife()
    {
        $this->entity->strength = 11;
        $this->entity->constitution = 10;

        $this->assertEquals(11, $this->entity->life);
    }
}
