<?php

namespace WebDevBr\ArenaPHP\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use WebDevBr\ArenaPHP\DaemonRules\Fight;
use WebDevBr\ArenaPHP\Entity\Fighter;
use WebDevBr\ArenaPHP\Battle;

class BattleCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('battle:fight')
            ->setDescription('Lute agora!')
            ->addArgument(
                'enemy',
                InputArgument::REQUIRED,
                'qual inimigo quer enfrentar?'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fighter_data = file_get_contents(__DIR__.'/../../data/player/fighter.json');
        $fighter_data = json_decode($fighter_data, true);

        $fighter = new Fighter;
        $fighter->name = $fighter_data['name'];
        $fighter->strength = $fighter_data['strength'];
        $fighter->agility = $fighter_data['agility'];
        $fighter->constitution = $fighter_data['constitution'];

        $enemy_data = file_get_contents(__DIR__.'/../../data/enemies/'.$input->getArgument('enemy').'.json');
        $enemy_data = json_decode($enemy_data, true);

        if (!$enemy_data) {
            $output->writeln('Inimigo não encontrado');
            exit;
        }

        $enemy = new Fighter;
        $enemy->name = $enemy_data['name'];
        $enemy->strength = $enemy_data['strength'];
        $enemy->agility = $enemy_data['agility'];
        $enemy->constitution = $enemy_data['constitution'];

        $attack_fighter = new Fight($fighter, $enemy);
        $attack_enemy = new Fight($enemy, $fighter);

        $output->writeln("==================");

        $output->writeln("Você tem {$fighter->life} de vida");
        $output->writeln("Sua ficha: Força: {$fighter->strength} - Agilidade: {$fighter->agility} - Constituição: {$fighter->constitution}");
        $output->writeln("Seu adversário tem {$enemy->life} de vida");
        $output->writeln("Seu inimigo: Força: {$enemy->strength} - Agilidade: {$enemy->agility} - Constituição: {$enemy->constitution}");

        $output->writeln("==================");

        $battle = new Battle($fighter, $enemy);
        $log = $battle->fight();

        foreach ($log as $k=>$v) {
            $output->writeln("");
            $output->writeln("==================");
            $output->writeln("Round {$k}... Fight!!!!");

            if ($v['battle']['fighter']['result'] === 1) {
                $output->writeln(sprintf("Você causou %s de dano ao inimigo!", $v['battle']['fighter']['damage']));
            }

            if ($v['battle']['fighter']['result'] === -1) {
                $output->writeln(sprintf("Você escorregou. Perca %s de vida!", $v['battle']['fighter']['damage']));
            }

            if ($v['battle']['fighter']['result'] === 0) {
                $output->writeln("Você errou!");
            }

            if ($v['battle']['enemy']['result'] === 1) {
                $output->writeln(sprintf("Seu inimigo acertou e você perdeu %s de vida!", $v['battle']['enemy']['damage']));
            }

            if ($v['battle']['enemy']['result'] === -1) {
                $output->writeln(sprintf("O inimigo escorregou e tomou %s de vida!", $v['battle']['enemy']['damage']));
            }

            if ($v['battle']['enemy']['result'] === 0) {
                $output->writeln("Seu inimigo errou!");
            }

            $output->writeln("------------------");

            $output->writeln("Você está com ".$v['battle']['fighter']['life']." de vida");
            $output->writeln("Seu inimigo está com ".$v['battle']['enemy']['life']." de vida");
        }

        $output->writeln("==================");
        $output->writeln("==================");
        $output->writeln("");
        $output->writeln("");
        $output->writeln("==================");
        $output->writeln("Resultado da luta!!!!");

        if ($v['battle']['fighter']['life'] <= 0) {
            $output->writeln("Você perdeu");
        }

        if ($v['battle']['fighter']['life'] > 0) {
            $output->writeln("Você ganhou");
        }

        if ($v['battle']['fighter']['life'] <= 0 and $v['battle']['enemy']['life'] <= 0) {
            $output->writeln("A luta acabou em empate");
        }
    }
}
