<?php

namespace zephy\ball\factory;

use pocketmine\utils\SingletonTrait;
use zephy\ball\arena\Arena;

class ArenaFactory
{
    use SingletonTrait {
        setInstance as private;
        reset as private;
    }
    /** @var Arena[]  */
    private array $arenas = [];

    public function getAll(): array
    {
        return $this->arenas;
    }
}