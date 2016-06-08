<?php

namespace WebDevBr\ArenaPHP\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use WebDevBr\ArenaPHP\Entity\Fighter;
use WebDevBr\ArenaPHP\Validation\Attributes;

class FighterCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('fighter:create')
            ->setDescription('Crie um lutador dividno 31 pontos entre os força, agilidade e constituição')
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'O nome do seu lutador'
            )
            ->addArgument(
                'strength',
                InputArgument::REQUIRED,
                'A força do seu lutador entre 5 e 18 (a média é 10)'
            )
            ->addArgument(
                'agility',
                InputArgument::REQUIRED,
                'A agilidade do seu lutador entre 5 e 18 (a média é 10)'
            )
            ->addArgument(
                'constitution',
                InputArgument::REQUIRED,
                'A constituição do seu lutador entre 5 e 18 (a média é 10)'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fighter = new Fighter;

        $fighter->name = $input->getArgument('name');
        $fighter->strength = $input->getArgument('strength');
        $fighter->agility = $input->getArgument('agility');
        $fighter->constitution = $input->getArgument('constitution');

        $this->validation = new Attributes;
        $this->validation->setFighter($fighter);

        $this->validation->setMin(5);
        $this->validation->setMax(18);
        $this->validation->setTotal(31);

        $total = $this->validation->checkTotal();
        if (!$total) {
            $output->writeln('A soma de força, agilidade e constituição deve ser 31!');
        }

        $strength = $this->validation->checkMinMax('strength');
        if (!$strength) {
            $output->writeln('A força deve ter um valor entre 5 e 18');
        }

        $agility = $this->validation->checkMinMax('agility');
        if (!$agility) {
            $output->writeln('A agilidade deve ter um valor entre 5 e 18');
        }

        $constitution = $this->validation->checkMinMax('constitution');
        if (!$constitution) {
            $output->writeln('A constituição deve ter um valor entre 5 e 18');
        }

        if ($total and $strength and $agility and $constitution) {
            $file = __DIR__.'/../../player/fighter.json';
            file_put_contents($file, json_encode($fighter->toArray()));
            $output->writeln('Seu lutador foi criado com sucesso!');
        }
    }
}
