<?php
declare(strict_types=1);

namespace Game;

use Exception;

class CharacterFactory
{
    /**
     * @return Character
     * @throws Exception
     */
    public static function getGenericMonster(): Character
    {
        $name = 'Generic Beast ' . random_int(1, 100);
        $health = new CharacterStat(60, 90);
        $strength = new CharacterStat(60, 90);
        $defence = new CharacterStat(40, 60);
        $speed = new CharacterStat(40, 60);
        $luck = new CharacterStat(25, 40);

        return new CharacterBase($name, $health, $strength, $defence, $speed, $luck);
    }

    /**
     * Just for show, extendable character stats
     * @return Character
     * @throws Exception
     */
    public static function getBigBoss(): Character
    {
        $name = 'Big Boss ' . random_int(0, PHP_INT_MAX);
        $health = new CharacterStatBig(150, 200);
        $strength = new CharacterStat(60, 90);
        $defence = new CharacterStat(40, 60);
        $speed = new CharacterStat(40, 60);
        $luck = new CharacterStat(25, 40);

        return new CharacterBase($name, $health, $strength, $defence, $speed, $luck);
    }

    /**
     * @param string $name
     * @return Character
     * @throws Exception
     */
    public static function getPlayer(string $name): Character
    {
        $health = new CharacterStat(70, 100);
        $strength = new CharacterStat(70, 80);
        $defence = new CharacterStat(45, 55);
        $speed = new CharacterStat(40, 50);
        $luck = new CharacterStat(10, 30);

        $player = new CharacterBase($name, $health, $strength, $defence, $speed, $luck);
        $player = new CharacterWithSkillMagicShield($player, 20);
        $player = new CharacterWithSkillRapidStrike($player, 10);

        return $player;
    }
}
