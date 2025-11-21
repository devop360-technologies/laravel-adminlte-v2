<?php

namespace Devop360Technologies\LaravelAdminLte\Menu\Filters;

use Devop360Technologies\LaravelAdminLte\Menu\Builder;

interface FilterInterface
{
    public function transform($item, Builder $builder);
}
