<?php

namespace zephy\ball\task;

use pocketmine\scheduler\Task;
use zephy\ball\arena\Arena;
use Exception;
use zephy\ball\stages\types\RefillStage;

class GameScheduler extends Task
{

    /**
     * @param Arena $arena
     * @throws Exception
     */
    public function __construct(
        private readonly Arena $arena,
    )
    {
        $this->arena->initialize();
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function onRun(): void
    {
        $this->arena->tick();
    }
}