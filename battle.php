<?php
#!/usr/bin/env php

require __DIR__.'/vendor/autoload.php';

use WebDevBr\ArenaPHP\Command\FighterCommand;
use WebDevBr\ArenaPHP\Command\BattleCommand;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new FighterCommand);
$application->add(new BattleCommand);
$application->run();
