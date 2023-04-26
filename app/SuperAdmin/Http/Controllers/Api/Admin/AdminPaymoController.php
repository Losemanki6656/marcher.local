<?php

namespace App\SuperAdmin\Http\Controllers\Api\Admin;

use App\Http\Controllers\ApiBaseController;
use App\Models\Company;
use App\Models\Product;
use App\Models\BindedCard;
use App\Models\SubscriptionPlan;
use App\SuperAdmin\Models\PaymentTranscation;
use Examyou\RestAPI\ApiResponse;
use Examyou\RestAPI\Exceptions\ApiException;
use Vinkla\Hashids\Facades\Hashids;
use App\SuperAdmin\Traits\StripeSettings;
use App\SuperAdmin\Http\Requests\Api\Admin\StripePaymentRequest;
use App\SuperAdmin\Http\Requests\Api\Admin\PaymoPaymentRequest;
use App\SuperAdmin\Http\Requests\Api\Admin\BindCardRequest;
use App\SuperAdmin\Http\Requests\Api\Admin\ConfirmPaymoRequest;
use App\SuperAdmin\Classes\SuperAdminCommon;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class AdminPaymoController  extends ApiBaseController
{
    use StripeSettings;

    public function paymoPayment(PaymoPaymentRequest $request)
    {
        $loggedInUser = user();

        $methodPaymo = SuperAdminCommon::getAppPaymoSettings();

        if (!$methodPaymo) {
            throw new ApiException('Subscription Method Paymo Not Exists');
        }
        
        $paymoToken = $this->AtmosToken( $methodPaymo['paymo_api_key'], $methodPaymo['paymo_api_secret'] );
        
        $planType = $request->plan_type;

        $convertedId = Hashids::decode($request->plan_id);

        $planId = $convertedId[0];

        $plan = SubscriptionPlan::find($planId);

        if (!$plan) {
            throw new ApiException('Subscription Plan Not Exists');
        }

        if($planType == "monthly") $amount = $plan->monthly_price;
        if($planType == "annual") $amount = $plan->annual_price;
      
        
        // $lastPaymentTranscation = PaymentTranscation::online()->with(['subscriptionPlan'])->whereNotNull('paid_on')->latest()->first();

        $cardNum = $this->replace($request->cardNumber);

        $expiries = explode('/', $request->expirationDate);

        $expirationDate = $expiries[1] . $expiries[0];

        // $paymoBindCard = $this->AtmosBindCard($paymoToken, $cardNum, $expirationDate);

        $paymoBindCard = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '. $paymoToken
        ])->post('https://partner.atmos.uz/partner/bind-card/create', [
            "card_number" =>  $cardNum,
            "expiry" => $expirationDate
        ]);

        $paymoBindCard = json_decode($paymoBindCard->body(), true);
        
        try {
                if ( $paymoBindCard['result']['code'] == "STPIMS-ERR-133" ) {

                    $response = Http::withHeaders([
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer '. $paymoToken
                    ])->post('https://partner.atmos.uz/merchant/pay/create', [
                        "amount" =>  $amount,
                        "account" => $loggedInUser->id,
                        "terminal_id" => $methodPaymo['paymo_terminal_id'],
                        "store_id" => $methodPaymo['paymo_store_id'],
                        "lang" => "ru"
                    ]);
                    
                    $response = json_decode($response->body(), true);

                   if($response['result']['code'] == "OK" ) {

                        $res = Http::withHeaders([
                            'Accept' => 'application/json',
                            'Authorization' => 'Bearer '. $paymoToken
                        ])->post('https://partner.atmos.uz/merchant/pay/pre-confirm', [
                            "card_token" =>  $paymoBindCard['data']['card_token'],
                            "store_id" =>  $methodPaymo['paymo_store_id'],
                            "transaction_id" => $response['transaction_id'],
                        ]);
                        
                        $res = json_decode($res->body(), true);

                        if($res['result']['code'] == "OK" ) {

                            $bind = BindedCard::where('card_id', $paymoBindCard['data']['card_id'])->first();

                            return response()->json([
                                'data' => [
                                    'status' => true,
                                    'cardStatus' => true,
                                    'bindID' => $bind->id ?? '',
                                    'transaction_id' => $response['transaction_id']
                                ]
                            ]);

                        
                        }

                        else{
                            return response()->json([
                                'status' => false,
                                'error' => [
                                    'message' => $res['result']['description']
                                ]
                            ], 400);
                        }

                   } else {
                    
                    return response()->json([
                        'status' => false,
                        'error' => [
                            'message' => $response['result']['description']
                        ]
                    ], 400);
                   }
                    
                // $bind = BindedCard::where('card_id', $paymoBindCard['data']['card_id'])->first();

                // return response()->json([
                //     'data' => [
                //         'status' => true,
                //         'cardStatus' => true,
                //         'bindID' => $bind->id
                //     ]
                // ]);

            } else {


                if ($paymoBindCard['transaction_id'] == null) {
                    
                    return response()->json([
                        'status' => false,
                        'error' => [
                            'message' => $paymoBindCard['result']['description']
                        ]
                    ], 404);
                    

                } else {
                   
                    return response()->json([
                        'data' => [
                            'status' => false,
                            'cardStatus' => false,
                            'transaction_id' => $paymoBindCard['transaction_id']
                        ]
                    ]);

                }
                
            }

        } catch (\Exception $e) {

            return ApiResponse::make('Success', [
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }

    }

    public function confirmPaymo(ConfirmPaymoRequest $request)
    {
        $methodPaymo = SuperAdminCommon::getAppPaymoSettings();

        if (!$methodPaymo) {
            throw new ApiException('Subscription Method Paymo Not Exists');
        }

        $loggedUser = user();
        $loggedUserCompany = company();

        $planType = $request->plan_type;

        $convertedId = Hashids::decode($request->plan_id);

        $planId = $convertedId[0];

        $plan = SubscriptionPlan::find($planId);

        if (!$plan) {
            throw new ApiException('Subscription Plan Not Exists');
        }

        $productCount = Product::count();
        if ($plan->max_products < $productCount) {
            throw new ApiException('You can not downgrade plan because you have added ' . $productCount . ' products while your new plan allow max products ' . $plan->max_products);
        }

        $paymoToken = $this->AtmosToken( $methodPaymo['paymo_api_key'], $methodPaymo['paymo_api_secret'] );

        try {

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '. $paymoToken
            ])->post('https://partner.atmos.uz/merchant/pay/confirm', [
                "transaction_id" =>  $request->transaction_id,
                "otp" => $request->otp,
                "store_id" =>  $methodPaymo['paymo_store_id'],
            ]);

            $response = json_decode($response->body(), true);

            if($response['result']['code'] == "OK" ) { 
               
                $amount = 0;
                if($planType == "monthly") $amount = $plan->monthly_price;
                if($planType == "annual") $amount = $plan->annual_price;

                $lastPaymentTranscation = PaymentTranscation::where('status','approved')->whereNotNull('paid_on')->latest()->first();

                if($lastPaymentTranscation)
                     $next_Date = $lastPaymentTranscation->next_payment_date; 
                else
                     $next_Date = now();

                $offlineRequest = new PaymentTranscation();
                $offlineRequest->payment_method = "Online";
                $offlineRequest->company_id = $loggedUserCompany->id;
                $offlineRequest->subscription_plan_id = $planId;
                $offlineRequest->plan_type = $request->plan_type;
                $offlineRequest->binded_card_id = $request->bindID;
                $offlineRequest->status = 'approved';
                $offlineRequest->transcation_id = $response['store_transaction']['success_trans_id'];
                $offlineRequest->total = $amount;
                $offlineRequest->paid_on = now();
                if($planType == "annual") $offlineRequest->next_payment_date = date('Y-m-d', strtotime($next_Date->addYear()));
                if($planType == "monthly") $offlineRequest->next_payment_date = date('Y-m-d', strtotime($next_Date->addMonth()));
                $offlineRequest->response_data = $response;
                $offlineRequest->save();

                $company = Company::find(company()->id);
                $company->subscription_plan_id = $planId;
                $company->package_type = $request->plan_type;
                $company->payment_transcation_id = $offlineRequest->id;
                $company->status = 'active';
                $company->licence_expire_on = $offlineRequest->next_payment_date;
                $company->save();

                return ApiResponse::make('Success', [
                    'success' => true,
                    'message' => 'Payment successfully done.',
                ]);

                return redirect(route('admin.subscription-plan.subscribe'));
                
            }
            else {
                return response()->json([
                    'status' => false,
                    'error' => [
                        'message' => $response['result']['description']
                    ]
                ], 400);
            }
            


        } catch (\Exception $e) {

            return ApiResponse::make('Success', [
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function bindCard(BindCardRequest $request)
    {
        
        $methodPaymo = SuperAdminCommon::getAppPaymoSettings();

        if (!$methodPaymo) {
            throw new ApiException('Subscription Method Paymo Not Exists');
        }
        $paymoToken = $this->AtmosToken( $methodPaymo['paymo_api_key'], $methodPaymo['paymo_api_secret'] );
        
        $planType = $request->plan_type;

        $convertedId = Hashids::decode($request->plan_id);

        $planId = $convertedId[0];

        $plan = SubscriptionPlan::find($planId);

        if (!$plan) {
            throw new ApiException('Subscription Plan Not Exists');
        }

        if($planType == "monthly") $amount = $plan->monthly_price;
        if($planType == "annual") $amount = $plan->annual_price;
      


        try {

            $respon = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '. $paymoToken
            ])->post('https://partner.atmos.uz/partner/bind-card/apply', [
                "transaction_id" =>  $request->transaction_id,
                "otp" => $request->verification_code
            ]);

            $respon = json_decode($respon->body(), true);

            if($respon['result']['code'] == "OK")
            {
                $loggedInUser = user();

                $newCard = new BindedCard();
                $newCard->user_id = $loggedInUser->id;
                $newCard->card_id = $respon['data']['card_id'];
                $newCard->pan = $respon['data']['pan'];
                $newCard->expiry = $respon['data']['expiry'];
                $newCard->card_holder = $respon['data']['card_holder'];
                $newCard->balance = $respon['data']['balance'];
                $newCard->phone = $respon['data']['phone'];
                $newCard->card_token = $respon['data']['card_token'];
                $newCard->save();

                
                $response = Http::withHeaders([
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer '. $paymoToken
                ])->post('https://partner.atmos.uz/merchant/pay/create', [
                    "amount" =>  $amount,
                    "account" => $loggedInUser->id,
                    "terminal_id" =>  $methodPaymo['paymo_terminal_id'],
                    "store_id" =>  $methodPaymo['paymo_store_id'],
                    "lang" => "ru"
                ]);

               if($response['result']['code'] == "OK" ) {

                    $res = Http::withHeaders([
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer '. $paymoToken
                    ])->post('https://partner.atmos.uz/merchant/pay/pre-confirm', [
                        "card_token" =>  $newCard->card_token,
                        "store_id" =>  $methodPaymo['paymo_store_id'],
                        "transaction_id" => $response['transaction_id'],
                    ]);

                    if($res['result']['code'] == "OK" ) {

                        return response()->json([
                            'data' => [
                                'status' => true,
                                'cardStatus' => true,
                                'bindID' => $newCard->id,
                                'transaction_id' => $response['transaction_id']
                            ]
                        ]);

                    
                    }

                    else{
                        return response()->json([
                            'status' => false,
                            'error' => [
                                'message' => $res['result']['description']
                            ]
                        ], 400);
                    }

               } else {
                
                return response()->json([
                    'status' => false,
                    'error' => [
                        'message' => $response['result']['description']
                    ]
                ], 400);
               }

            }
            else 
            return response()->json([
                'status' => false,
                'error' => [
                    'message' => $response['result']['description']
                ]
            ], 400);
            

        } catch (\Exception $e) {

            $error = [
                'status' => false,
                'message' => $e->getMessage()
            ];

            return response()->json($error);
        }
    }

    public function AtmosToken($username, $password)
    {
        try {

            $client = new Client();
            $url = 'https://partner.atmos.uz/token';

            $response = $client->request('POST', $url, [
                'headers' =>  [
                    'Accept' => 'application/json',
                ],
                'query' => 'grant_type=client_credentials',
                'auth' => [
                    $username, 
                    $password
                ]
            ]);

            // $response = json_decode($response->body(), true);

            $info = json_decode($response->getBody()->getContents(), true); 

            return $info['access_token'];

        } catch (\Exception $e) {

            return ApiResponse::make('Success', [
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function AtmosBindCard( $token, $cardNum, $expirationDate )
    {
        try {

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '. $token
            ])->post('https://partner.atmos.uz/partner/bind-card/create', [
                "card_number" =>  $cardNum,
                "expiry" => $expirationDate
            ]);

            return $response;
            

        } catch (\Exception $e) {

            $error = [
                'status' => false,
                'message' => $e->getMessage()
            ];

            return response()->json($error);
        }
    }

    public function replace($text)
    {
        $sym1 = ["/",' '];

        $sym2 = ['',''];

        return str_replace($sym1, $sym2, $text);
    }
   
}
