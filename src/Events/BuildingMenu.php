<?php

namespace Devop360Technologies\LaravelAdminLte\Events;

use Devop360Technologies\LaravelAdminLte\Menu\Builder;

class BuildingMenu
{
    public $menu;

    public function __construct(Builder $menu)
    {
        $this->menu = $menu;
    }
}
