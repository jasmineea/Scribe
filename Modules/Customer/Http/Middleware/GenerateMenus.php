<?php

namespace Modules\Customer\Http\Middleware;

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
            // comments
            $menu->add('<i class="nav-icon fas fa-user-group"></i> Customers', [
                'route' => 'backend.customers.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order' => 2,
                'activematches' => ['admin/customers*'],
                'permission' => ['view_customers'],
            ])
            ->link->attr([
                'class' => 'nav-link',
            ]);
        })->sortBy('order');

        return $next($request);
    }
}
