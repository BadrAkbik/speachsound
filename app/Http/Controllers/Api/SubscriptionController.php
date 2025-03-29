<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\SubscriptionResource;
use App\Models\Plan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubscriptionController extends BaseController
{
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'plan_id' => ['required', 'integer', 'exists:plans,id'],
            'coupon' => ['nullable', 'exists:table,column']
        ]);
        $user = auth()->user();
        if($user->has('subscription')->count()){
            return $this->withError(__('api.already_subscribed'), 400);
        }

        $plan = Plan::find($validated['plan_id']);

        if($plan->periodicity_type === 'month'){
            $period = $plan->period  * 30;
        }elseif($plan->periodicity_type === 'year'){
            $period = $plan->period  * 365;
        }else{
            $period = $plan->period;
        }

        $subscription = $user->subscription()->create([
            'plan_id' => (int) $validated['plan_id'],
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addDays($period),
            'status' => 'active',
        ]);

        return $this->withSuccess([
            'subscription' => new SubscriptionResource($subscription),
        ], __('api.subscribed_successfully'));
    }
    
    public function currentSubscription()
    {
        $user = auth()->user();
        if($user->has('subscription')->count()){
            return new SubscriptionResource($user->subscription);
        }else{
            return $this->withSuccess(message: __('api.no_subscription'));
        }
    }
}
