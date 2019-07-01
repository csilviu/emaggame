<?php
declare(strict_types=1);

namespace Game;

class Battle
{
    /** @var Character $currentAttacker */
    private $currentAttacker;
    /** @var Character $currentDefender */
    private $currentDefender;

    /** @var int $maxTurns */
    private $maxTurns;
    /** @var int $currentTurn */
    private $currentTurn;

    /**
     * @param Character $fighter1
     * @param Character $fighter2
     * @param int $max_turns
     */
    public function __construct(Character $fighter1, Character $fighter2, int $max_turns)
    {
        $speedFighter1 = $fighter1->getStats()['speed']['current'];
        $speedFighter2 = $fighter2->getStats()['speed']['current'];
        switch ($speedFighter1 <=> $speedFighter2){
            case 1:
                $this->currentAttacker = $fighter1;
                $this->currentDefender = $fighter2;
                break;

            case -1:
                $this->currentAttacker = $fighter2;
                $this->currentDefender = $fighter1;
                break;

            case 0:
                $luckFighter1 = $fighter1->getStats()['luck']['current'];
                $luckFighter2 = $fighter2->getStats()['luck']['current'];
                switch ($luckFighter1 <=> $luckFighter2){
                    case 0:
                    case 1:
                        $this->currentAttacker = $fighter1;
                        $this->currentDefender = $fighter2;
                        break;
                    case -1:
                        $this->currentAttacker = $fighter2;
                        $this->currentDefender = $fighter1;
                        break;
                }
                break;
        }

        $this->maxTurns = $max_turns;
        $this->currentTurn = 0;

        echo sprintf(
            PHP_EOL . 'Battle starting for %d turns!' . PHP_EOL . 'Attacker: %s.' . PHP_EOL . 'Defender: %s' . PHP_EOL,
            $this->maxTurns,
            self::getFormattedCharacterDetails($this->currentAttacker),
            self::getFormattedCharacterDetails($this->currentDefender)
        );
    }

    public function fight(): void
    {
        while($this->isBattleStillOn()){
            $this->doTurn();
            $this->switchRoles();
        }

        if($this->currentAttacker->getStats()['health']['current'] === 0) {
            echo sprintf(PHP_EOL . '<%s> WON!', $this->currentDefender->getName());
        }elseif($this->currentDefender->getStats()['health']['current'] === 0) {
            echo sprintf(PHP_EOL . '<%s> WON!', $this->currentAttacker->getName());
        }else {
            echo PHP_EOL . 'Nobody won!';
        }
    }

    private function isBattleStillOn(): bool
    {
        return
            $this->currentTurn < $this->maxTurns
            && $this->currentAttacker->getStats()['health']['current'] > 0
            && $this->currentDefender->getStats()['health']['current'] > 0;
    }

    private function doTurn(): void
    {
        $this->currentTurn++;
        echo sprintf(PHP_EOL . 'Turn %d!', $this->currentTurn);

        echo sprintf( PHP_EOL . '<%s> attacks', $this->currentAttacker->getName());
        $damage = $this->currentAttacker->attack($this->currentDefender);

        echo sprintf(PHP_EOL .'<%s> defends', $this->currentDefender->getName());

        $defenderRemainingHealth = $this->currentDefender->defend($damage, $this->currentAttacker);
        echo sprintf(PHP_EOL .'<%s>\'s remaining health: %d', $this->currentDefender->getName(), $defenderRemainingHealth);
    }

    public function switchRoles(): void
    {
        if (!$this->isBattleStillOn()) {
            return;
        }

        $temp = $this->currentAttacker;
        $this->currentAttacker = $this->currentDefender;
        $this->currentDefender = $temp;

        echo sprintf(
            PHP_EOL . 'Roles switched!' . PHP_EOL . 'Attacker: %s.' . PHP_EOL . 'Defender: %s.' . PHP_EOL,
            self::getFormattedCharacterDetails($this->currentAttacker),
            self::getFormattedCharacterDetails($this->currentDefender)
        );
    }

    /**
     * @param Character $character
     * @return string
     */
    public static function getFormattedCharacterDetails(Character $character): string
    {
        $stats = $character->getStats();
        return sprintf(
            '<%s> [health: %2d, strength: %2d, defence: %2d, speed: %2d, luck: %2d]',
            $character->getName(),
            $stats['health']['current'],
            $stats['strength']['current'],
            $stats['defence']['current'],
            $stats['speed']['current'],
            $stats['luck']['current']
        );
    }

    /**
     * @return int
     */
    public function getMaxTurns(): int
    {
        return $this->maxTurns;
    }

    /**
     * @return int
     */
    public function getCurrentTurn(): int
    {
        return $this->currentTurn;
    }

    /**
     * @return Character
     */
    public function getCurrentAttacker(): Character
    {
        return $this->currentAttacker;
    }

    /**
     * @return Character
     */
    public function getCurrentDefender(): Character
    {
        return $this->currentDefender;
    }
}
