<?php
declare(strict_types=1);

namespace Game;

/**
 * Implements Decorator pattern; base decorator class
 */
abstract class CharacterWithSkill implements Character
{
    /** @var Character */
    protected $character;

    public function __construct(Character $character)
    {
        $this->character = $character;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->character->getName();
    }

    /**
     * @return array
     */
    public function getStats(): array
    {
        return $this->character->getStats();
    }

    /**
     * @return bool
     */
    public function isLucky(): bool
    {
        return $this->character->isLucky();
    }

    /**
     * @param Character $defender
     * @return int
     */
    public function attack(Character $defender): int
    {
        return $this->character->attack($defender);
    }

    /**
     * @param int $damage
     * @param Character $attacker
     * @return int
     */
    public function defend(int $damage, Character $attacker): int
    {
        return $this->character->defend($damage, $attacker);
    }
}