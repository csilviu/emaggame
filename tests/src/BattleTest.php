<?php
declare(strict_types=1);

namespace Game;

use PHPUnit\Framework\TestCase;

class BattleTest extends TestCase
{
    /** @var CharacterBase */
    private $fighterSlowSpeed, $fighterNormal, $fighterHighLuck, $fighterNormal1;

    public function setUp(): void
    {
        $this->fighterSlowSpeed = $this->createMock(CharacterBase::class);
        $this->fighterSlowSpeed->method('getName')->willReturn('Fighter slow speed');
        $this->fighterSlowSpeed->method('getStats')->willReturn(
            [
                'name' => $this->fighterSlowSpeed->getName(),
                'health' => ['min' => 0, 'max' => 100, 'current' => 50],
                'strength' => ['min' => 0, 'max' => 100, 'current' => 50],
                'defence' => ['min' => 0, 'max' => 100, 'current' => 50],
                'speed' => ['min' => 0, 'max' => 100, 'current' => 10],
                'luck' => ['min' => 0, 'max' => 100, 'current' => 50],
            ]
        );

        $this->fighterNormal = $this->createMock(CharacterBase::class);
        $this->fighterNormal->method('getName')->willReturn('Fighter normal');
        $this->fighterNormal->method('getStats')->willReturn(
            [
                'name' => $this->fighterNormal->getName(),
                'health' => ['min' => 0, 'max' => 100, 'current' => 80],
                'strength' => ['min' => 0, 'max' => 100, 'current' => 70],
                'defence' => ['min' => 0, 'max' => 100, 'current' => 60],
                'speed' => ['min' => 0, 'max' => 100, 'current' => 50],
                'luck' => ['min' => 0, 'max' => 100, 'current' => 50],
            ]
        );

        $this->fighterNormal1 = $this->createMock(CharacterBase::class);
        $this->fighterNormal1->method('getName')->willReturn('Fighter normal1');
        $this->fighterNormal1->method('getStats')->willReturn(
            [
                'name' => $this->fighterNormal1->getName(),
                'health' => ['min' => 0, 'max' => 100, 'current' => 80],
                'strength' => ['min' => 0, 'max' => 100, 'current' => 70],
                'defence' => ['min' => 0, 'max' => 100, 'current' => 60],
                'speed' => ['min' => 0, 'max' => 100, 'current' => 50],
                'luck' => ['min' => 0, 'max' => 100, 'current' => 50],
            ]
        );

        $this->fighterHighLuck = $this->createMock(CharacterBase::class);
        $this->fighterHighLuck->method('getName')->willReturn('Fighter high luck');
        $this->fighterHighLuck->method('getStats')->willReturn(
            [
                'name' => $this->fighterHighLuck->getName(),
                'health' => ['min' => 0, 'max' => 100, 'current' => 50],
                'strength' => ['min' => 0, 'max' => 100, 'current' => 50],
                'defence' => ['min' => 0, 'max' => 100, 'current' => 50],
                'speed' => ['min' => 0, 'max' => 100, 'current' => 50],
                'luck' => ['min' => 0, 'max' => 100, 'current' => 90],
            ]
        );
    }

    public function testCreateBattleSetTurns(): void
    {
        $battle = new Battle($this->fighterSlowSpeed, $this->fighterNormal, 20);
        $this->expectOutputRegex('/Battle starting/');

        $this->assertEquals(20, $battle->getMaxTurns(), 'Maximum turns is not correct');
        $this->assertEquals(0, $battle->getCurrentTurn(), 'Current turn at beginning is not correct');
    }

    public function testCreateBattleSlowSpeedVsNormal(): void
    {
        $battle = new Battle($this->fighterSlowSpeed, $this->fighterNormal, 5);
        $this->expectOutputRegex('/Battle starting/');
        $this->assertSame($this->fighterSlowSpeed, $battle->getCurrentDefender(), 'Slow speed fighter should be defender against normal fighter');
        $this->assertSame($this->fighterNormal, $battle->getCurrentAttacker(), 'Normal fighter should be attacker against slow speed fighter');
    }

    public function testCreateBattleNormalVsSlowSpeed(): void
    {
        $battle = new Battle($this->fighterNormal, $this->fighterSlowSpeed, 5);
        $this->expectOutputRegex('/Battle starting/');
        $this->assertSame($this->fighterSlowSpeed, $battle->getCurrentDefender(), 'Slow speed fighter should be defender against normal fighter');
        $this->assertSame($this->fighterNormal, $battle->getCurrentAttacker(), 'Normal fighter should be attacker against slow speed fighter');
    }

    public function testCreateBattleSlowSpeedVsHighLuck(): void
    {
        $battle = new Battle($this->fighterSlowSpeed, $this->fighterHighLuck, 5);
        $this->expectOutputRegex('/Battle starting/');
        $this->assertSame($this->fighterSlowSpeed, $battle->getCurrentDefender(), 'Slow speed fighter should be defender against high luck fighter');
        $this->assertSame($this->fighterHighLuck, $battle->getCurrentAttacker(), 'High luck fighter should be attacker against slow speed fighter');
    }

    public function testCreateBattleNormalVsHighLuck(): void
    {
        $battle = new Battle($this->fighterNormal, $this->fighterHighLuck, 5);
        $this->expectOutputRegex('/Battle starting/');
        $this->assertSame($this->fighterNormal, $battle->getCurrentDefender(), 'Normal fighter should be defender against high luck fighter');
        $this->assertSame($this->fighterHighLuck, $battle->getCurrentAttacker(), 'High luck fighter should be attacker against normal fighter');
    }

    public function testCreateBattleSameSpeedSameLuck(): void
    {
        $battle = new Battle($this->fighterNormal, $this->fighterNormal1, 5);
        $this->expectOutputRegex('/Battle starting/');
        $this->assertSame($this->fighterNormal, $battle->getCurrentAttacker(), 'First fighter should be attacker against first fighter');
        $this->assertSame($this->fighterNormal1, $battle->getCurrentDefender(), 'Second fighter should be defender against first fighter');
    }

    public function testCreateBattleSameSpeedHighLuckVsLowLuck(): void
    {
        $battle = new Battle($this->fighterHighLuck, $this->fighterNormal, 5);
        $this->expectOutputRegex('/Battle starting/');
        $this->assertSame($this->fighterNormal, $battle->getCurrentDefender(), 'Normal fighter should be defender against high luck fighter');
        $this->assertSame($this->fighterHighLuck, $battle->getCurrentAttacker(), 'High luck fighter should be attacker against normal fighter');
    }

    public function testSwitchRoles(): void
    {
        $battle = new Battle($this->fighterSlowSpeed, $this->fighterNormal, 5);
        $battle->switchRoles();
        $this->expectOutputRegex('/Roles switched!/');

        $this->assertSame($this->fighterSlowSpeed, $battle->getCurrentAttacker(), 'After switching roles, slow speed fighter should be attacker to normal fighter');
        $this->assertSame($this->fighterNormal, $battle->getCurrentDefender(), 'After switching roles, normal figher shold be defender from slow speed fighter');
    }

    public function testGetFormattedCharacterDetails(): void
    {
        $expected_result = sprintf(
            '<%s> [health: %2d, strength: %2d, defence: %2d, speed: %2d, luck: %2d]',
            'Fighter normal', 80, 70, 60, 50, 50
        );

        $this->assertEquals($expected_result, Battle::getFormattedCharacterDetails($this->fighterNormal));
    }

    public function testFightNumberOfTurns(): void
    {
        $battle = new Battle($this->fighterSlowSpeed, $this->fighterNormal, 5);
        $battle->fight();
        $this->expectOutputRegex('/Turn 1!/');

        $this->assertEquals(5, $battle->getCurrentTurn());
    }

    public function testFightAttackerWins(): void
    {
        $health1 = new CharacterStat(100, 100);
        $strength1 = clone $health1;
        $defence1 = clone $health1;
        $speed1 = clone $health1;
        $luck1 = clone $health1;
        $fighter1 = new CharacterBase('Fighter 1', $health1, $strength1, $defence1, $speed1, $luck1);

        $health2 = new CharacterStat(1, 1);
        $strength2 = clone $health2;
        $defence2 = clone $health2;
        $speed2 = clone $health2;
        $luck2 = clone $health2;
        $fighter2 = new CharacterBase('Fighter 2', $health2, $strength2, $defence2, $speed2, $luck2);

        $battle = new Battle($fighter1, $fighter2, 5);
        $battle->fight();
        $this->expectOutputRegex('/<Fighter 1> WON!/');
    }

    public function testFightDefenderWins(): void
    {
        $health1 = new CharacterStat(100, 100);
        $strength1 = clone $health1;
        $defence1 = clone $health1;
        $speed1 = new CharacterStat(0, 0);
        $luck1 = clone $speed1;
        $fighter1 = new CharacterBase('Fighter 1', $health1, $strength1, $defence1, $speed1, $luck1);

        $health2 = new CharacterStat(1, 1);
        $strength2 = clone $health2;
        $defence2 = clone $health2;
        $speed2 = new CharacterStat(100, 100);
        $luck2 = clone $health2;
        $fighter2 = new CharacterBase('Fighter 2', $health2, $strength2, $defence2, $speed2, $luck2);

        $battle = new Battle($fighter1, $fighter2, 5);
        $battle->fight();
        $this->expectOutputRegex('/<Fighter 2> WON!/');
    }
}