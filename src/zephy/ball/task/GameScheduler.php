<?php

namespace zephy\ball\task;

use pocketmine\scheduler\Task;
use zephy\ball\arena\Arena;
use Exception;

class GameScheduler extends Task
{

    private int $timer = 0;

    /**
     * @param Arena $arena
     */
    public function __construct(
        private readonly Arena $arena,
    )
    {}

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function onRun(): void
    {
        $this->arena->initialize();

        $this->timer++;
    }
}