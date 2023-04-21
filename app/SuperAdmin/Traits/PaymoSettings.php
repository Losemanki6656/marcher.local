<?php

namespace App\SuperAdmin\Traits;

use App\Scopes\CompanyScope;
use App\SuperAdmin\Models\GlobalSettings;
use Illuminate\Support\Facades\Config;

trait PaymoSettings
{
    public function setStripConfigs()
    {
        $stripeSettings = GlobalSettings::withoutGlobalScope(CompanyScope::class)
            ->where('setting_type', 'payment_settings')
            ->where('name_key', 'stripe')
            ->first();
        $settings = (object) $stripeSettings->credentials;

        $key       = ($settings->paymo_api_key) ? $settings->paymo_api_key : env('paymo_KEY');
        $apiSecret = ($settings->paymo_api_secret) ? $settings->paymo_api_secret : env('paymo_SECRET');
        // $webhookKey = ($settings->paymo_webhook_key) ? $settings->paymo_webhook_key : env('paymo_WEBHOOK_SECRET');

        Config::set('cashier.key', $key);
        Config::set('cashier.secret', $apiSecret);
        Config::set('cashier.webhook.secret', $webhookKey);
    }
}
