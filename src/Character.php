<?php
declare(strict_types=1);

namespace Game;

interface Character
{
    public function getName();

    public function getStats(): array;

    public function isLucky(): bool;

    public function attack(Character $defender): int;

    public function defend(int $damage, Character $attacker): int;
}