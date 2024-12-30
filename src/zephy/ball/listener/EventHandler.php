<?php

namespace zephy\ball\listener;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerQuitEvent;
use zephy\ball\factory\ArenaFactory;
use zephy\ball\stages\types\EndStage;

class EventHandler implements Listener
{
    public function onDeath(PlayerDeathEvent $event): void
    {
        $player = $event->getPlayer();

        foreach (ArenaFactory::getInstance()->getStartedArenas() as $arena) {
            $session = $arena->sessions[$player->getName()];
            $session?->getPlayer()?->teleport($session->getBed());
        }
    }

    public function onQuit(PlayerQuitEvent $event): void
    {
        $player = $event->getPlayer();

        foreach (ArenaFactory::getInstance()->getStartedArenas() as $arena) {
            $session = $arena->sessions[$player->getName()] ?? null;

            if (isset($session)) {
                $filter = array_filter(
                    $arena->sessions,
                    fn($otherSession) => $otherSession->getPlayer()->getName() !== $player->getName()
                );
                $winner = reset($filter);
                $arena->stage = new EndStage($winner->getPlayer());

            }
        }
    }
}