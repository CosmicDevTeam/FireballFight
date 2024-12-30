<?php

namespace zephy\ball\entity;

use pocketmine\block\Block;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\entity\projectile\Projectile;
use pocketmine\math\RayTraceResult;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;

class FireballEntity extends Projectile
{

    protected function getInitialSizeInfo(): EntitySizeInfo
    {
        return new EntitySizeInfo(0.5, 0.5);
    }

    /**
     * @inheritDoc
     */
    protected function getInitialDragMultiplier(): float
    {
        return 0.01;
    }

    /**
     * @inheritDoc
     */
    protected function getInitialGravity(): float
    {
        return 0.0;
    }

    protected function onHitBlock(Block $blockHit, RayTraceResult $hitResult): void
    {
        $nearby = $this->getWorld()->getNearbyEntities($this->boundingBox->expandedCopy(1, 1, 1));
        foreach ($nearby as $entity) {
            $direction = $entity->getPosition()->subtract($this->getPosition()->x, $this->getPosition()->y, $this->getPosition()->z)->normalize();
            $entity->setMotion($direction->multiply(1.5)); 
        }
    }

    public static function getNetworkTypeId(): string
    {
        return EntityIds::FIREBALL;
    }
}