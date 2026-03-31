<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use App\Models\FiscalYear;
use Illuminate\Support\Facades\View;
use App\Models\AdministrativeCase;
use App\Models\AdministrativeReport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
            Paginator::useBootstrapFive();

            // ✅ ALWAYS SORTED (latest → oldest)
         View::composer('layouts.app', function ($view) {

                $years = FiscalYear::orderByDesc('year')->get();

                $groupedCases = AdministrativeCase::whereNull('name')
                    ->get()
                    ->sortByDesc(function ($item) {
                        preg_match('/As of (.*)$/', $item->report_title, $matches);
                        return isset($matches[1]) ? strtotime($matches[1]) : 0;
                    })
                    ->groupBy('report_title');
                        $groupedCases = AdministrativeReport::latest()
                            ->get()
                            ->groupBy('report_title');
                            
                $view->with([
                    'sidebarYears' => $years,
                    'groupedCases' => $groupedCases
                ]);
            });

            // Force https only in production
            if (app()->environment('production')) {
                URL::forceScheme('https');
            }
     }
}
