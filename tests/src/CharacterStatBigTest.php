<?php
declare(strict_types=1);

namespace Game;

use PHPUnit\Framework\TestCase;

class CharacterStatBigTest extends TestCase
{
    /**
     * @return array
     */
    public function goodValueDataProvider(): array
    {
        return [
            ['value' => -100],
            ['value' => 0],
            ['value' => 50],
            ['value' => 100],
            ['value' => 200],
        ];
    }

    /**
     * @return array
     */
    public function badValueDataProvider(): array
    {
        return [
            ['value' => -101],
            ['value' => 201],
        ];
    }

    /**
     * @dataProvider goodValueDataProvider
     * @param int $value
     * @throws \Exception
     */
    public function testGetMinValue($value): void
    {
        $playerStat = new CharacterStatBig($value, CharacterStatBig::MAX_LIMIT);
        $this->assertEquals($value, $playerStat->getMin());
    }

    /**
     * @dataProvider goodValueDataProvider
     * @param int $value
     * @throws \Exception
     */
    public function testGetMaxValue($value): void
    {
        $playerStat = new CharacterStatBig(CharacterStatBig::MIN_LIMIT, $value);
        $this->assertEquals($value, $playerStat->getMax());
    }

    public function testGetValue(): void
    {
        $playerStat = new CharacterStatBig(CharacterStatBig::MIN_LIMIT, CharacterStatBig::MAX_LIMIT);
        $this->assertLessThanOrEqual($playerStat->getCurrent(),CharacterStatBig::MIN_LIMIT, 'CharacterStat should NOT be smaller than ' . CharacterStatBig::MIN_LIMIT);
        $this->assertGreaterThanOrEqual($playerStat->getCurrent(), CharacterStatBig::MAX_LIMIT, 'CharacterStat should NOT be greater than ' . CharacterStatBig::MAX_LIMIT);
    }

    /**
     * @dataProvider goodValueDataProvider
     * @param int $value
     * @throws \Exception
     */
    public function testSetValue($value): void
    {
        $playerStat = new CharacterStatBig(CharacterStatBig::MIN_LIMIT, CharacterStatBig::MAX_LIMIT);
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
        new CharacterStatBig($value, CharacterStatBig::MAX_LIMIT);
    }

    /**
     * @dataProvider badValueDataProvider
     * @param int $value
     * @throws \Exception
     */
    public function testSetMaxValueException($value): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $playerStat = new CharacterStatBig(CharacterStatBig::MIN_LIMIT, $value);
    }

    /**
     * @dataProvider badValueDataProvider
     * @param int $value
     * @throws \Exception
     */
    public function testSetValueException($value): void
    {
        $playerStat = new CharacterStatBig(CharacterStatBig::MIN_LIMIT, CharacterStatBig::MAX_LIMIT);
        $this->expectException(\InvalidArgumentException::class);
        $playerStat->setCurrent($value);
    }

    public function testMinBiggerThanMaxValueException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageRegExp('/needs to be >= than/');
        new CharacterStatBig(CharacterStatBig::MAX_LIMIT, CharacterStatBig::MIN_LIMIT);
    }

    public function testGetValues(): void
    {
        $playerStat = new CharacterStatBig(-10, 190);
        $playerStat->setCurrent(50);

        $result = $playerStat->getValues();
        $expected = [
            'min' => -10,
            'current' => 50,
            'max' => 190,
        ];

        $this->assertEquals($expected, $result);
    }
}
