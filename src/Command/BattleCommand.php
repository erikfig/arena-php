<?php

namespace WebDevBr\ArenaPHP\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use WebDevBr\ArenaPHP\DaemonRules\Fight;
use WebDevBr\ArenaPHP\Entity\Fighter;

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

        $round = 1;

        while ($fighter->life > 0) {
            $output->writeln("");
            $output->writeln("==================");
            $output->writeln("Round {$round}... Fight!!!!");

            $fighter_attack_result = $attack_fighter->battle();

            if ($fighter_attack_result === 1) {
                $dano = $attack_fighter->damageWithoutWeapons();
                $enemy->life -= $dano;
                $output->writeln("Você causou {$dano} de dano ao inimigo!");
            }

            if ($fighter_attack_result === -1) {
                $dano = $attack_fighter->damageWithoutWeapons()*2;
                $fighter->life -= $dano;
                $output->writeln("Você escorregou. Perca {$dano} de vida!");
            }

            if ($fighter_attack_result === 0) {
                $output->writeln("Você errou!");
            }

            $enemy_attack_result = $attack_enemy->battle();

            if ($enemy_attack_result === 1 and $enemy->life > 0) {
                $dano = $attack_fighter->damageWithoutWeapons();
                $fighter->life -= $dano;
                $output->writeln("Seu inimigo acertou e você perdeu {$dano} de vida!");
            }

            if ($enemy_attack_result === -1 and $enemy->life > 0) {
                $dano = $attack_fighter->damageWithoutWeapons()*2;
                $enemy->life -= $dano;
                $output->writeln("O inimigo escorregou e tomou {$dano} de vida");
            }

            if ($enemy_attack_result === 0 and $enemy->life > 0) {
                $output->writeln("Seu inimigo errou");
            }

            $output->writeln("------------------");

            $output->writeln("Você está com ".$fighter->life." de vida");
            $output->writeln("Seu inimigo está com ".$enemy->life." de vida");
            $round++;

            if ($enemy->life <= 0) {
                break;
            }
        }

        $output->writeln("==================");
        $output->writeln("Resultado da luta!!!!");

        if ($fighter->life <= 0) {
            $output->writeln("Você perdeu");
        }

        if ($enemy->life <= 0 and $fighter->life > 0) {
            $output->writeln("Você ganhou");
        }

        if ($fighter->life <= 0 and $enemy->life <= 0) {
            $output->writeln("A luta acabou em empate");
        }
    }
}
