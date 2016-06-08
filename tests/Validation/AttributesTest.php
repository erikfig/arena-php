<?php

namespace WebDevBr\ArenaPHP\Validation;

use WebDevBr\ArenaPHP\Entity\Fighter;

class AttributesTest extends \PHPUnit_Framework_TestCase
{
    private $validation;

    protected function setUp()
    {
        $fighter = new Fighter;
        $fighter->strength = 19;
        $fighter->agility = 4;
        $fighter->constitution = 18;

        $this->validation = new Attributes;
        $this->validation->setFighter($fighter);

        $this->validation->setMin(5);
        $this->validation->setMax(18);
        $this->validation->setTotal(30);
    }

    public function testCheckTotalPoints()
    {
        $check = $this->validation->checkTotal();
        $this->assertEquals(false, $check);
    }

    public function testCheckMinMaxPerAtribute()
    {
        $check = $this->validation->checkMinMax('strength');
        $this->assertEquals(false, $check);

        $check = $this->validation->checkMinMax('agility');
        $this->assertEquals(false, $check);

        $check = $this->validation->checkMinMax('constitution');
        $this->assertEquals(true, $check);
    }
}
