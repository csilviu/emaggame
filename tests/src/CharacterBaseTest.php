<?php
declare(strict_types=1);

namespace Game;

use PHPUnit\Framework\TestCase;

class CharacterBaseTest extends TestCase
{
    /** @var CharacterStat */
    private $health, $strength, $defence, $speed, $luck;

    /** @var CharacterBase */
    private $character;

    public function setUp(): void
    {
        $this->health = new CharacterStat(10, 95);
        $this->health->setCurrent(55);

        $this->strength = new CharacterStat(20, 90);
        $this->strength->setCurrent(66);

        $this->defence = new CharacterStat(30, 80);
        $this->defence->setCurrent(77);

        $this->speed = new CharacterStat(40, 70);
        $this->speed->setCurrent(44);

        $this->luck = new CharacterStat(50, 60);
        $this->luck->setCurrent(55);

        $this->character = new CharacterBase('Bob', $this->health, $this->strength, $this->defence, $this->speed, $this->luck);
    }

    public function testGetStats(): void
    {
        $stats = [
            'name' => 'Bob',
            'health' => ['min' => 10, 'max' => 95, 'current' => 55],
            'strength' => ['min' => 20, 'max' => 90, 'current' => 66],
            'defence' => ['min' => 30, 'max' => 80, 'current' => 77],
            'speed' => ['min' => 40, 'max' => 70, 'current' => 44],
            'luck' => ['min' => 50, 'max' => 60, 'current' => 55],
        ];
        $this->assertEquals($this->character->getStats(), $stats);
    }

    public function testGetName(): void
    {
        $this->assertEquals($this->character->getName(), 'Bob');
    }

    public function testIsLucky(){
        $lucky = new CharacterStat(100, 100);
        $character = new CharacterBase('Bob', $this->health, $this->strength, $this->defence, $this->speed, $lucky);

        $this->assertEquals($character->isLucky(), true);

        $unlucky = new CharacterStat(0, 0);
        $character = new CharacterBase('Bob', $this->health, $this->strength, $this->defence, $this->speed, $unlucky);
        $this->expectOutputRegex('/got lucky/');

        $this->assertEquals($character->isLucky(), false);
    }
}