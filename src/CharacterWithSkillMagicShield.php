<?php
declare(strict_types=1);

namespace Game;

/**
 * Magic shield: Takes only half of the usual damage when an enemy attacks; there’s a 20% change he’ll use this skill every time he defends.
 */
class CharacterWithSkillMagicShield extends CharacterWithSkill
{
    private const SKILL_NAME = 'Magic Shield';

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

    public function defend(int $damage, Character $attacker): int
    {
        if($this->isActive()) {
            echo PHP_EOL . 'SKILL ' . self::SKILL_NAME . ' used';
            $damage = (int)($damage / 2);
        }

        return parent::defend($damage, $attacker);
    }

    private function isActive(){
        return $this->chance >= random_int(0, 100);
    }
}