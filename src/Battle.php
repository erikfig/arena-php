<?php

namespace WebDevBr\ArenaPHP;

use WebDevBr\ArenaPHP\DaemonRules\Fight;
use WebDevBr\ArenaPHP\Entity\Fighter;

class Battle
{
    private $fighter;
    private $enemy;

    public function __construct(Fighter $fighter,Fighter $enemy)
    {
        $this->fighter = $fighter;
        $this->enemy = $enemy;

        $this->attack_fighter = new Fight($fighter, $enemy);
        $this->attack_enemy = new Fight($enemy, $fighter);
    }

    public function fight()
    {
        $fight_log = [];

        $round = 1;
        while ($this->fighter->life > 0) {

            $fight_log[$round]['battle']['fighter'] = $this->attack('fighter');

            if ($this->enemy->life > 0) {
                $fight_log[$round]['battle']['enemy'] = $this->attack('enemy');
            } else {
                $fight_log[$round]['battle']['enemy'] = [
                    'result'=>null
                ];
            }

            $fight_log[$round]['battle']['fighter']['life'] = $this->fighter->life;
            $fight_log[$round]['battle']['enemy']['life'] = $this->enemy->life;

            $round++;

            if ($this->enemy->life <= 0) {
                break;
            }
        }

        return $fight_log;
    }

    public function attack($attacker)
    {
        $attack = 'attack_'.$attacker;
        $enemy = 'enemy';

        if ($attacker == 'enemy') {
            $enemy = 'fighter';
        }

        $result = $this->$attack->battle();
        $damage = $this->$attack->damageWithoutWeapons();

        if ($result === 1) {
            $this->$enemy->life -= $damage;
        }

        if ($result === -1) {
            $damage *= 2;
            $this->$attacker->life -= $damage;
        }

        return [
            'result'=>$result,
            'damage'=>$damage
        ];
    }
}
