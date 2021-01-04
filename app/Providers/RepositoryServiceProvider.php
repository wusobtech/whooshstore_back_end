<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\App\Repositories\ProductsRepository::class, \App\Repositories\ProductsRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RecentlyViewedProductRepository::class, \App\Repositories\RecentlyViewedProductRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ProductRepository::class, \App\Repositories\ProductRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ProductCategoryRepository::class, \App\Repositories\ProductCategoryRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\BillingAddressRepository::class, \App\Repositories\BillingAddressRepositoryEloquent::class);
        //:end-bindings:
    }
}
