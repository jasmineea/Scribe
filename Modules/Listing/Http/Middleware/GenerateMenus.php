<?php

namespace Modules\Listing\Http\Middleware;

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
            $menu->add('<i class="nav-icon fas fa-list"></i> Recipients', [
                'route' => 'backend.listings.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order' => 6,
                'activematches' => ['admin/listings*'],
                'permission' => ['view_listings'],
            ])
            ->link->attr([
                'class' => 'nav-link',
            ]);
        })->sortBy('order');

        return $next($request);
    }
}
