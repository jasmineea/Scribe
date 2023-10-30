<?php

namespace Modules\Order\Http\Middleware;

use Closure;

class GenerateMenus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /*
         *
         * Module Menu for Admin Backend
         *
         * *********************************************************************
         */

        \Menu::make('admin_sidebar', function ($menu) {

            // Access Control Dropdown
            $accessControl = $menu->add('<i class="nav-icon fas fa-shopping-cart"></i> Campaigns', [
                'class' => 'nav-group',
            ])
            ->data([
                'order' => 3,
                'activematches' => [
                    'admin/orders*'
                ],
                'permission' => ['view_orders'],
            ]);
            $accessControl->link->attr([
                'class' => 'nav-link nav-group-toggle',
                'href' => '#',
            ]);

            // Submenu: Users
            $accessControl->add('<i class="nav-icon fa-solid fa-cart-plus"></i> Published Campaigns', [
                'route' => ['backend.orders.index', 'type' => 'published'],
                'class' => 'nav-item',
            ])
            ->data([
                'order' => 4,
                'activematches' => 'admin/orders?type=published*',
                'permission' => ['view_orders'],
            ])
            ->link->attr([
                'class' => 'nav-link',
            ]);

            // Submenu: Roles
            $accessControl->add('<i class="nav-icon fa-solid fa-cart-arrow-down"></i> Draft Campaigns', [
                'route' => ['backend.orders.index', 'type' => 'draft'],
                'class' => 'nav-item',
            ])
            ->data([
                'order' => 5,
                'activematches' => 'admin/orders?type=draft*',
                'permission' => ['view_orders'],
            ])
            ->link->attr([
                'class' => 'nav-link',
            ]);

        })->sortBy('order');

        \Menu::make('admin_sidebar', function ($menu) {
            // comments
            $menu->add('<i class="nav-icon fas fa-file"></i> Master Print Files', [
                'route' => 'backend.orders.masterfiles',
                'class' => 'nav-item',
            ])
            ->data([
                'order' => 8,
                'activematches' => ['admin/masterfiles*'],
                'permission' => ['view_masterfiles'],
            ])
            ->link->attr([
                'class' => 'nav-link',
            ]);
        })->sortBy('order');

        \Menu::make('admin_sidebar', function ($menu) {
            // comments
            $menu->add('<i class="nav-icon fas fa-file"></i> Master Design Files', [
                'route' => 'backend.orders.masterdesignfiles',
                'class' => 'nav-item',
            ])
            ->data([
                'order' => 8,
                'activematches' => ['admin/masterdesignfiles*'],
                'permission' => ['view_masterdesignfiles'],
            ])
            ->link->attr([
                'class' => 'nav-link',
            ]);
        })->sortBy('order');

        return $next($request);
    }
}
