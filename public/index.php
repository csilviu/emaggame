<?php
declare(strict_types=1);

// lots of tests to be done, if time permitted

use Game\Battle;
use Game\CharacterFactory;

require __DIR__ . '/../vendor/autoload.php';

$name = 'Orderus';
$player = CharacterFactory::getPlayer($name);

$beast = CharacterFactory::getGenericMonster();
//$boss = CharacterFactory::getBigBoss();

$battle = new Battle($player, $beast, 20);
$battle->fight();

echo PHP_EOL . 'Finished!' . PHP_EOL;