<?php
declare(strict_types=1);

namespace Game;

/**
 * Rapid strike: Strike twice while it’s his turn to attack; there’s a 10% chance he’ll use this skill every time he attacks
 */
class CharacterWithSkillRapidStrike extends CharacterWithSkill
{
    private const SKILL_NAME = 'Rapid Strike';

    /** @var int $chance */
    private $chance;

    /**
     * @param Character $character
     * @param int $chance
     */
    public function __construct(Character $character, int $chance)
    {
        $this->chance = $chance;
        parent::__construct($character);
    }

    public function attack(Character $defender): int
    {
        $damage = $this->character->getStats()['strength']['current'] - $defender->getStats()['defence']['current'];
        if ($damage < 0){
            $damage = 0;
        }

        if($this->isActive()) {
            echo PHP_EOL . 'SKILL ' . self::SKILL_NAME . ' used';
            $damage *= 2;
        }

        echo PHP_EOL . 'Damage dealt: ' . $damage;

        return $damage;
    }

    private function isActive(){
        return $this->chance >= random_int(0, 100);
    }

}