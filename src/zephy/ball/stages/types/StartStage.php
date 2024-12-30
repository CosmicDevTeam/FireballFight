<?php

namespace zephy\ball\stages\types;

use pocketmine\utils\TextFormat;
use zephy\ball\arena\Arena;
use zephy\ball\stages\Stage;
use zephy\ball\utils\KitUtils;

class StartStage extends Stage
{

    /**
     * @inheritDoc
     */
    public function onStart(Arena $arena): void
    {
        foreach ($arena->sessions as $session) {
            KitUtils::give($session->getPlayer());
            $session->getPlayer()->sendMessage(TextFormat::colorize("&cThe duel has started, be careful!"));
        }


    }

    /**
     * @inheritDoc
     */
    public function onStop(Arena $arena): void
    {
        // TODO: Implement onStop() method.
    }
}