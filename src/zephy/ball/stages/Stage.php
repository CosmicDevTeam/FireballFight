<?php

namespace zephy\ball\stages;

use zephy\ball\arena\Arena;

abstract class Stage
{

    /**
     * @param Arena $arena
     * @return void
     */
    abstract public function onStart(Arena $arena): void;


    /**
     * @param Arena $arena
     * @return void
     */
    abstract public function onStop(Arena $arena): void;
}