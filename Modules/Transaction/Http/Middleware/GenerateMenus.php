<?php

namespace Modules\Transaction\Http\Middleware;

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
            $menu->add('<i class="nav-icon fas fa-exchange"></i> Transactions', [
                'route' => 'backend.transactions.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order' => 7,
                'activematches' => ['admin/transactions*'],
                'permission' => ['view_orders'],
            ])
            ->link->attr([
                'class' => 'nav-link',
            ]);
        })->sortBy('order');

        return $next($request);
    }
}
