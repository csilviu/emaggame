<?php
declare(strict_types=1);

namespace Game;

use Exception;

class CharacterBase implements Character
{
    /** @var string $name */
    private $name;

    /** @var CharacterStat $heath */
    private $health;
    /** @var CharacterStat $strength */
    private $strength;
    /** @var CharacterStat $defence */
    private $defence;
    /** @var CharacterStat $speed */
    private $speed;
    /** @var CharacterStat $luck */
    private $luck;

    /**
     * @param string        $name
     * @param CharacterStat $health
     * @param CharacterStat $strength
     * @param CharacterStat $defence
     * @param CharacterStat $speed
     * @param CharacterStat $luck
     */
    public function __construct(string $name, CharacterStat $health, CharacterStat $strength, CharacterStat $defence, CharacterStat $speed, CharacterStat $luck)
    {
        $this->name = $name;
        $this->health = $health;
        $this->strength = $strength;
        $this->defence = $defence;
        $this->speed = $speed;
        $this->luck = $luck;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns a hash with CharacterBase details
     * @return array
     */
    public function getStats(): array
    {
        return [
            'name' => $this->getName(),
            'health' => $this->health->getValues(),
            'strength' => $this->strength->getValues(),
            'defence' => $this->defence->getValues(),
            'speed' => $this->speed->getValues(),
            'luck' => $this->luck->getValues(),
        ];
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function isLucky(): bool
    {
        $isLucky = $this->luck->getCurrent() >= random_int(0, 100);
        if($isLucky){
            echo PHP_EOL . '<' . $this->getName() . '> got lucky.';
        }

        return $isLucky;
    }

    /**
     * @param Character $defender
     * @return int Value of damage dealt
     */
    public function attack(Character $defender): int
    {
        $damage = $this->strength->getCurrent() - $defender->getStats()['defence']['current'];
        if ($damage < 0){
            $damage = 0;
        }
        echo PHP_EOL . 'Damage dealt: ' . $damage;

        return $damage;
    }

    /**
     * @param int $damage
     * @param Character $attacker In the future, defending might depend on attacker type, etc...
     * @return int Remaining health
     * @throws Exception
     */
    public function defend(int $damage, Character $attacker): int
    {
        $receivedDamage = $this->getReceivedBaseDamage($damage, $attacker);

        echo PHP_EOL . 'Damage received: ' . $receivedDamage;

        $this->updateHealth($receivedDamage);

        return $this->health->getCurrent();
    }

    /**
     * @param int $damage
     * @param Character $attacker
     * @return int
     * @throws Exception
     */
    protected function getReceivedBaseDamage(int $damage, Character $attacker): int
    {
        if($this->isLucky()) {
            $damage = 0;
        }

        if($damage < 0) {
            $damage = 0;
        }

        return $damage;
    }

    protected function updateHealth(int $receivedDamage): void
    {
        $newHeath = $this->health->getCurrent() - $receivedDamage;
        if ($newHeath < 0){
            $newHeath = 0;
        }
        $this->health->setCurrent($newHeath);
    }
}
