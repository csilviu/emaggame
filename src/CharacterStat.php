<?php
declare(strict_types=1);

namespace Game;

use Exception;

class CharacterStat
{
    public const MIN_LIMIT = 0;
    public const MAX_LIMIT = 100;

    /** @var int $min */
    private $min;

    /** @var int $max */
    private $max;

    /** @var int $current */
    private $current;

    /**
     * @param int $min Minimum value for CharacterStat range
     * @param int $max Maximum value for CharacterStat range
     * @throws Exception
     */
    public function __construct(int $min, int $max)
    {
        if ($min > $max) {
            throw new \InvalidArgumentException(
                sprintf('min needs to be >= than max. Given values: min %d, max %d', $min, $max)
            );
        }
        $this->setMin($min);
        $this->setMax($max);
        $this->initCurrent();
    }

    /**
     * @return int
     */
    public function getMin(): int
    {
        return $this->min;
    }

    /**
     * @param int $min
     * @throws \InvalidArgumentException
     */
    private function setMin(int $min): void
    {
        if ($min < static::MIN_LIMIT || $min > static::MAX_LIMIT) {
            throw new \InvalidArgumentException(
                sprintf('Value needs to be between %d and %d. Given value: %d', static::MIN_LIMIT,static::MAX_LIMIT, $min)
            );
        }
        $this->min = $min;
    }

    /**
     * @return int
     */
    public function getMax(): int
    {
        return $this->max;
    }

    /**
     * @param int $max
     * @throws \InvalidArgumentException
     */
    private function setMax(int $max): void
    {
        if ($max < static::MIN_LIMIT || $max > static::MAX_LIMIT) {
            throw new \InvalidArgumentException(
                sprintf('Value needs to be between %d and %d. Given value: %d', static::MIN_LIMIT,static::MAX_LIMIT, $max)
            );
        }
        $this->max = $max;
    }

    /**
     * @return int
     */
    public function getCurrent(): int
    {
        return $this->current;
    }

    /**
     * @param int $current
     */
    public function setCurrent(int $current): void
    {
        if ($current < static::MIN_LIMIT || $current > static::MAX_LIMIT) {
            throw new \InvalidArgumentException(
                sprintf('Value needs to be between %d and %d. Given value: %d', static::MIN_LIMIT,static::MAX_LIMIT, $current)
            );
        }
        $this->current = $current;
    }

    /**
     * Initializes the value with a random between $this->min and $this->max
     * @throws Exception
     */
    private function initCurrent(): void
    {
        $this->setCurrent(random_int($this->getMin(), $this->getMax()));
    }

    /**
     * Returns a hash with min, max and current values
     * @return array
     */
    public function getValues(): array
    {
        return [
            'min' => $this->min,
            'max' => $this->max,
            'current' => $this->current,
        ];
    }
}
