<?php

namespace WebDevBr\ArenaPHP\DaemonRules;

use WebDevBr\ArenaPHP\Entity\Fighter;

class Fight extends System
{
    public function __construct(Fighter $attacker, Fighter $defender)
    {
        $this->attacker = $attacker;
        $this->defender = $defender;

        if (!$this->attacker->agility) {
            throw new \Exception("Attacker require a agility value");
        }

        if (!$this->attacker->agility) {
            throw new \Exception("Attacker require a strength value");
        }

        if (!$this->defender->agility) {
            throw new \Exception("Defender require a agility value");
        }
    }

    public function battle()
    {
        $attacker = $this->attacker->agility * 4;
        $defender = $this->defender->agility * 4;

        $testValue = ($attacker-$defender) + 50;
        return $this->test($testValue);
    }

    public function damageWithoutWeapons()
    {
        $strength = $this->attacker->strength;
        return (int)$this->rollDice(3) + $this->strengthBonus($strength);
    }
}
