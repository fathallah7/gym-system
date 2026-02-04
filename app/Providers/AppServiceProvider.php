<?php

namespace App\Providers;

use App\Models\Invoice;
use App\Models\Member;
use App\Models\Membership;
use App\Models\Plan;
use App\Policies\InvoicePolicy;
use App\Policies\MemberPolicy;
use App\Policies\MembershipPolicy;
use App\Policies\PlanPolicy;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        // Register policies
        Gate::policy(Member::class, MemberPolicy::class);
        Gate::policy(Plan::class, PlanPolicy::class);
        Gate::policy(Membership::class, MembershipPolicy::class);
        Gate::policy(Invoice::class, InvoicePolicy::class);
    }

}
