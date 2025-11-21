<?php

namespace Devop360Technologies\LaravelAdminLte\Http\ViewComposers;

use Illuminate\View\View;
use Devop360Technologies\LaravelAdminLte\AdminLte;

class AdminLteComposer
{
    /**
     * @var AdminLte
     */
    private $adminlte;

    public function __construct(AdminLte $adminlte)
    {
        $this->adminlte = $adminlte;
    }

    public function compose(View $view)
    {
        $view->with('adminlte', $this->adminlte);
    }
}
