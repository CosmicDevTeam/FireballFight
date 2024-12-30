<?php

namespace zephy\ball\arena;

use pocketmine\block\Bed;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\world\Position;
use pocketmine\world\World;
use Exception;
use zephy\ball\stages\Stage;
use zephy\ball\stages\types\EndStage;
use zephy\ball\stages\types\RefillStage;
use zephy\ball\stages\types\StartStage;
use zephy\ball\stages\types\WaitingStage;
use zephy\ball\team\Session;

class Arena
{
    /** @var int  */
    private int $timer = 0;

    /** @var Stage */
    private Stage $stage;
    
    /** @var Session[] */
    private array $sessions = [];

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
    public function randTeams(array $players): void
    {
        shuffle($players);
        array_walk($players, function (Player $player, int $index) {
            $spawn = $this->data['spawn' . $index] ?? null;
            if ($spawn !== null) {
                $this->sessions[$player->getName()] = new Session($player, $spawn, $index);
            }
        });
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

        $this->randTeams(array_map([Server::getInstance(), 'getPlayerExact'], $this->getPlayers()));

        $this->stage = new StartStage();
        $this->stage->onStart($this);
    }

    /**
     * @return void
     */
    public function tick(): void
    {
        if (array_filter($this->sessions, fn($s) => !($this->world->getBlock($s->getBed()) instanceof Bed))) {
            $this->stage = new EndStage();
            $this->stage->onStart($this);
            return;
        }
        
        if ($this->timer === 180 and $this->stage instanceof StartStage) {
            (new RefillStage())->onStart($this);
        }
    }
}