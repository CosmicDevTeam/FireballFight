<?php

namespace zephy\ball\arena;

use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\world\Position;
use pocketmine\world\World;
use Exception;
use zephy\ball\stages\Stage;
use zephy\ball\stages\types\StartStage;
use zephy\ball\stages\types\WaitingStage;

class Arena
{
    /*** @var Stage */
    private Stage $stage;

    /**
     * @param string $identifier
     * @param World $world
     * @param array $data
     */
    public function __construct(
        private readonly string $identifier,
        private readonly World $world,
        private array $data
    )
    {
        $this->stage = new WaitingStage();
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @return World
     */
    public function getWorld(): World
    {
        return $this->world;
    }

    /**
     * @return string[]|null
     */
    public function getPlayers(): ?array
    {
        return $this->data["players"] ?? null;
    }

    /**
     * @param string[] $players
     * @return void
     */
    public function setPlayers(array $players): void
    {
        $this->data["players"] = $players;
    }

    /**
     * @param Player[] $players
     * @return void
     */
    public function randSpawns(array $players): void
    {
        /** @var Position[] $spawns */
        $spawns = [$this->data['spawn1'], $this->data['spawn2']];
        
        shuffle($spawns);
        foreach ($players as $index => $player) {
            if (isset($spawns[$index])) {
                $player->teleport($spawns[$index]);
            }
        }
    }

    /**
     * @return void
     * @throws Exception
     */
    public function initialize(): void
    {
        if(!$this->world->isLoaded()) {
            Server::getInstance()->getWorldManager()->loadWorld($this->world->getFolderName());
        }

        if(count($this->getPlayers()) > 2) {
            throw new Exception("Expected 2 players, but received " . count($this->getPlayers()));
        }

        $this->randSpawns(array_map([Server::getInstance(), 'getPlayerExact'], $this->getPlayers()));

        $this->stage = new StartStage();
        $this->stage->onStart($this);
    }
}