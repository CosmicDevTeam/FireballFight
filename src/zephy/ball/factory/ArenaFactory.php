<?php

namespace zephy\ball\factory;

use pocketmine\utils\SingletonTrait;
use zephy\ball\arena\Arena;
use zephy\ball\stages\types\StartStage;

class ArenaFactory
{
    use SingletonTrait {
        setInstance as private;
        reset as private;
    }
    /** @var Arena[]  */
    private array $arenas = [];

    /**
     * @return Arena[]
     */
    public function getAll(): array
    {
        return $this->arenas;
    }

    /**
     * @return Arena[]
     */
    public function getStartedArenas(): array
    {
        return array_filter($this->arenas, fn(Arena $arena) => $arena->getStage() instanceof StartStage);
    }
}