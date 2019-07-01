<?php
declare(strict_types=1);

namespace Game;

use PHPUnit\Framework\TestCase;

class CharacterStatTest extends TestCase
{
    /**
     * @return array
     */
    public function goodValueDataProvider(): array
    {
        return [
            ['value' => 0],
            ['value' => 1],
            ['value' => 50],
            ['value' => 99],
            ['value' => 100],
        ];
    }

    /**
     * @return array
     */
    public function badValueDataProvider(): array
    {
        return [
            ['value' => -1],
            ['value' => 101],
        ];
    }

    /**
     * @dataProvider goodValueDataProvider
     * @param int $value
     * @throws \Exception
     */
    public function testGetMinValue($value): void
    {
        $playerStat = new CharacterStat($value, CharacterStat::MAX_LIMIT);
        $this->assertEquals($value, $playerStat->getMin());
    }

    /**
     * @dataProvider goodValueDataProvider
     * @param int $value
     * @throws \Exception
     */
    public function testGetMaxValue($value): void
    {
        $playerStat = new CharacterStat(CharacterStat::MIN_LIMIT, $value);
        $this->assertEquals($value, $playerStat->getMax());
    }

    public function testGetValue(): void
    {
        $playerStat = new CharacterStat(CharacterStat::MIN_LIMIT, CharacterStat::MAX_LIMIT);
        $this->assertLessThanOrEqual($playerStat->getCurrent(), CharacterStat::MIN_LIMIT, 'CharacterStat should NOT be smaller than ' . CharacterStat::MIN_LIMIT);
        $this->assertGreaterThanOrEqual($playerStat->getCurrent(), CharacterStat::MAX_LIMIT, 'CharacterStat should NOT be greater than ' . CharacterStat::MAX_LIMIT);
    }

    /**
     * @dataProvider goodValueDataProvider
     * @param int $value
     * @throws \Exception
     */
    public function testSetValue($value): void
    {
        $playerStat = new CharacterStat(CharacterStat::MIN_LIMIT, CharacterStat::MAX_LIMIT);
        $playerStat->setCurrent($value);
        $this->assertEquals($value, $playerStat->getCurrent());
    }

    /**
     * @dataProvider badValueDataProvider
     * @param int $value
     * @throws \Exception
     */
    public function testSetMinValueException($value): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new CharacterStat($value, CharacterStat::MAX_LIMIT);
    }

    /**
     * @dataProvider badValueDataProvider
     * @param int $value
     * @throws \Exception
     */
    public function testSetMaxValueException($value): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $playerStat = new CharacterStat(CharacterStat::MIN_LIMIT, $value);
    }

    /**
     * @dataProvider badValueDataProvider
     * @param int $value
     * @throws \Exception
     */
    public function testSetValueException($value): void
    {
        $playerStat = new CharacterStat(CharacterStat::MIN_LIMIT, CharacterStat::MAX_LIMIT);
        $this->expectException(\InvalidArgumentException::class);
        $playerStat->setCurrent($value);
    }

    public function testMinBiggerThanMaxValueException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageRegExp('/needs to be >= than/');
        new CharacterStat(CharacterStat::MAX_LIMIT, CharacterStat::MIN_LIMIT);
    }

    public function testGetValues(): void
    {
        $playerStat = new CharacterStat(10, 90);
        $playerStat->setCurrent(50);

        $result = $playerStat->getValues();
        $expected = [
            'min' => 10,
            'current' => 50,
            'max' => 90,
        ];

        $this->assertEquals($expected, $result);
    }
}
