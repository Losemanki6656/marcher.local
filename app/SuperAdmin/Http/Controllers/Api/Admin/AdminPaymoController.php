<?php

namespace App\SuperAdmin\Http\Controllers\Api\Admin;

use App\Http\Controllers\ApiBaseController;
use App\Models\Company;
use App\Models\Product;
use App\Models\SubscriptionPlan;
use App\SuperAdmin\Models\PaymentTranscation;
use Examyou\RestAPI\ApiResponse;
use Examyou\RestAPI\Exceptions\ApiException;
use Vinkla\Hashids\Facades\Hashids;
use App\SuperAdmin\Traits\StripeSettings;
use App\SuperAdmin\Http\Requests\Api\Admin\StripePaymentRequest;
use App\SuperAdmin\Http\Requests\Api\Admin\PaymoPaymentRequest;
use App\SuperAdmin\Classes\SuperAdminCommon;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class AdminPaymoController  extends ApiBaseController
{
    use StripeSettings;

    public function paymoPayment(PaymoPaymentRequest $request)
    {

        $methodPaymo = SuperAdminCommon::getAppPaymoSettings();

        if (!$methodPaymo) {
            throw new ApiException('Subscription Method Paymo Not Exists');
        }

        $client             = new Client();
        $url                = 'https://partner.atmos.uz';

        $headers = [
            'Content-type'  => 'application/json; charset=utf-8',
            'Accept'        => 'application/json',
            'Authorization' => 'Basic base64_encode('. $methodPaymo->paymo_api_key .':' . $methodPaymo->paymo_api_secret . ')',
        ];

        $response       = $client->request('POST', $url, [
            'headers'   => $headers,
            'query' => 'grant_type=client_credentials'
        ]);
        
        $info               = json_decode($response->getBody()->getContents(), true); 
        return $info;

        

        $planType = $request->plan_type;

        $convertedId = Hashids::decode($request->plan_id);

        $planId = $convertedId[0];

        // return $planId;

        // Check if subscription plan exists or not
        $plan = SubscriptionPlan::find(1);
        if (!$plan) {
            throw new ApiException('Subscription Plan Not Exists');
        }

        $lastPaymentTranscation = PaymentTranscation::online()->with(['subscriptionPlan'])->whereNotNull('paid_on')->latest()->first();

        $subcriptionCancel = true;

        if (!is_null($lastPaymentTranscation) && $lastPaymentTranscation->payment_method == 'paymo') {
            $subcriptionCancel = $this->cancelSubscriptionPaymo();
        }

        if ($subcriptionCancel) {
            $productCount = Product::count();

            if ($plan->max_products < $productCount) {
                throw new ApiException('You can not downgrade plan because you have added ' . $productCount . ' products while your new plan allow max products ' . $plan->max_products);
            }

            $company = Company::find(company()->id);
            $subscription = $company->subscriptions;

            try {
                if ($subscription->count() > 0) {
                    $company->subscription('main')->swap($plan->{'stripe_' . $planType . '_plan_id'});
                } else {

                    $company->newSubscription('main', $plan->{'stripe_' . $planType . '_plan_id'})->create($token, [
                        'email' => $email,
                    ]);
                }

                $company->subscription_plan_id = $plan->id;
                $company->package_type = $planType;

                // Set company status active
                $company->status = 'active';
                $company->licence_expire_on = null;

                $company->save();

                //send superadmin notification
                // $generatedBy = User::whereNull('company_id')->get();
                //Notification::send($generatedBy, new CompanyUpdatedPlan($company, $plan->id));

                return ApiResponse::make('Success', [
                    'success' => true,
                    'message' => 'Payment successfully done.',
                ]);

                return redirect(route('admin.subscription-plan.subscribe'));

            } catch (\Exception $e) {
                return ApiResponse::make('Success', [
                    'success' => false,
                    'message' => $e->getMessage(),
                ]);
            }
        }
    }

    public function stripePayment(StripePaymentRequest $request)
    {
        $this->setStripConfigs();
        $token = $request->stripe_token;
        $email = $request->email;
        $planType = $request->plan_type;

        $convertedId = Hashids::decode($request->plan_id);
        $planId = $convertedId[0];

        // Check if subscription plan exists or not
        $plan = SubscriptionPlan::find($planId);
        if (!$plan) {
            throw new ApiException('Subscription Plan Not Exists');
        }

        $lastPaymentTranscation = PaymentTranscation::online()->with(['subscriptionPlan'])->whereNotNull('paid_on')->latest()->first();

        $subcriptionCancel = true;

        if (!is_null($lastPaymentTranscation) && $lastPaymentTranscation->payment_method == 'paypal') {
            $subcriptionCancel = $this->cancelSubscriptionPaypal();
        }
        if (!is_null($lastPaymentTranscation) && $lastPaymentTranscation->payment_method == 'razorpay') {
            $subcriptionCancel = $this->cancelSubscriptionRazorpay();
        }

        if ($subcriptionCancel) {
            $productCount = Product::count();

            if ($plan->max_products < $productCount) {
                throw new ApiException('You can not downgrade plan because you have added ' . $productCount . ' products while your new plan allow max products ' . $plan->max_products);
            }

            $company = Company::find(company()->id);
            $subscription = $company->subscriptions;

            try {
                if ($subscription->count() > 0) {
                    $company->subscription('main')->swap($plan->{'stripe_' . $planType . '_plan_id'});
                } else {

                    $company->newSubscription('main', $plan->{'stripe_' . $planType . '_plan_id'})->create($token, [
                        'email' => $email,
                    ]);
                }

                $company->subscription_plan_id = $plan->id;
                $company->package_type = $planType;

                // Set company status active
                $company->status = 'active';
                $company->licence_expire_on = null;

                $company->save();

                //send superadmin notification
                // $generatedBy = User::whereNull('company_id')->get();
                //Notification::send($generatedBy, new CompanyUpdatedPlan($company, $plan->id));

                return ApiResponse::make('Success', [
                    'success' => true,
                    'message' => 'Payment successfully done.',
                ]);

                return redirect(route('admin.subscription-plan.subscribe'));
            } catch (\Exception $e) {
                return ApiResponse::make('Success', [
                    'success' => false,
                    'message' => $e->getMessage(),
                ]);
            }
        }
    }
}
