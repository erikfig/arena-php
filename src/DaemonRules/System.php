<?php

namespace WebDevBr\ArenaPHP\DaemonRules;

abstract class System
{
    public function test($testValue)
    {
        $diceValue = $this->rollDice(100);

        if ($diceValue >= 95) {
            return -1;
        }

        if ($diceValue > $testValue) {
            return 0;
        }

        return 1;
    }

    public function rollDice($faces, $quantity = 1)
    {
        if (!is_int($faces) || !is_int($quantity)) {
            throw new \Exception("Faces and quantity must be integers.");
        }

        $total = 0;
        for ($i=0; $i < $quantity; $i++) {
            $total += rand(1, $faces);
        }

        return $total;
    }

    public function strengthBonus($strength)
    {
        if ($strength == 1 or $strength ==2) {
            return -3;
        }

        if ($strength == 3 or $strength ==4) {
            return -2;
        }

        if ($strength == 5 or $strength ==6) {
            return -1;
        }

        if ($strength == 7 or $strength ==8) {
            return -1;
        }

        if ($strength > 14) {
            return ceil(($strength - 14) / 2);
        }

        return 0;
    }
}
