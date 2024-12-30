<?php

namespace zephy\ball\stages\types;

use pocketmine\player\Player;
use zephy\ball\arena\Arena;
use zephy\ball\Loader;
use zephy\ball\stages\Stage;
use zephy\ball\task\GameScheduler;

class EndStage extends Stage
{

    public function __construct(private readonly Player $winner)
    {}

    /**
     * @inheritDoc
     */
    public function onStart(Arena $arena): void
    {
        // TODO: Implement onStart() method.
    }

    /**
     * @inheritDoc
     */
    public function onStop(Arena $arena): void
    {
        // TODO: Implement onStop() method.
    }
}