<?php

namespace WebDevBr\ArenaPHP\DaemonRules;

use WebDevBr\ArenaPHP\Entity\Fighter;

class FightTest extends \PHPUnit_Framework_TestCase
{
    private $fight;

    protected function setUp()
    {
        $attacker = new Fighter;
        $attacker->strength = 18;
        $attacker->agility = 10;
        $attacker->constitution = 12;

        $defender = new Fighter;
        $defender->strength = 12;
        $defender->agility = 18;
        $defender->constitution = 10;

        $this->fight = new Fight($attacker, $defender);
    }

    public function testAttack()
    {
        $result = $this->fight->battle();

        $this->assertContains($result, [-1, 0, 1]);
    }

    public function testDamageWithoutWeapons()
    {
        $result = $this->fight->damageWithoutWeapons();
        $this->assertLessThanOrEqual(5, $result);
        $this->assertGreaterThanOrEqual(3, $result);
    }

}
