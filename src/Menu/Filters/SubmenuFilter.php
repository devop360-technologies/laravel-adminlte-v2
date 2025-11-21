<?php

namespace Devop360Technologies\LaravelAdminLte\Menu\Filters;

use Devop360Technologies\LaravelAdminLte\Menu\Builder;
use Devop360Technologies\LaravelAdminLte\Menu\ActiveChecker;

class SubmenuFilter implements FilterInterface
{
    private $activeChecker;

    public function __construct(ActiveChecker $activeChecker)
    {
        $this->activeChecker = $activeChecker;
    }

    public function transform($item, Builder $builder)
    {
        if (isset($item['submenu'])) {
            $item['submenu'] = $builder->transformItems($item['submenu']);
            $item['submenu_open'] = $this->activeChecker->isActive($item);
            $item['submenu_classes'] = $this->makeSubmenuClasses();
            $item['submenu_class'] = implode(' ', $item['submenu_classes']);
        }

        return $item;
    }

    protected function makeSubmenuClasses()
    {
        $classes = ['treeview-menu'];

        return $classes;
    }
}
