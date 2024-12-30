<?php

namespace zephy\ball\team;

use pocketmine\player\Player;
use pocketmine\world\Position;

readonly class Session
{
    public function __construct(
        private readonly Player $player,
        private readonly Position $bed,
        private readonly int $team
    )
    {}

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function getBed(): Position
    {
        return $this->bed;
    }

    public function getTeam(): int
    {
        return $this->team;
    }
}