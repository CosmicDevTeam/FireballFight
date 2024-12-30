<?php

namespace zephy\ball\utils;

use pocketmine\player\Player;
use pocketmine\item\VanillaItems;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\VanillaEnchantments;

class KitUtils
{
    public static function give(Player $player)
    {
        $armor = $player->getArmorInventory();
        $protection = new EnchantmentInstance(VanillaEnchantments::PROTECTION(), 3);

        $armor->setHelmet(VanillaItems::DIAMOND_HELMET()->addEnchantment($protection));
        $armor->setChestplate(VanillaItems::DIAMOND_CHESTPLATE()->addEnchantment($protection));
        $armor->setLeggings(VanillaItems::DIAMOND_LEGGINGS()->addEnchantment($protection));
        $armor->setBoots(VanillaItems::DIAMOND_BOOTS()->addEnchantment($protection));

        $inventory = $player->getInventory();
        $sharpness = new EnchantmentInstance(VanillaEnchantments::SHARPNESS(), 2);
        $inventory->addItem(VanillaItems::DIAMOND_SWORD()->addEnchantment($sharpness));
        $inventory->addItem(VanillaItems::FIRE_CHARGE()->setCount(16));
        $inventory->addItem(VanillaItems::GOLDEN_APPLE()->setCount(20));
    }
}