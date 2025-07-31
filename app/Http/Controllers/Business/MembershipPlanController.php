<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\MembershipPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MembershipPlanController extends Controller
{
    public function index(Business $business)
    {
        $plans = Cache::remember("business.{$business->id}.membership_plans", 300, function () use ($business) {
            return $business->membershipPlans()
                ->active()
                ->withCount(['subscriptions', 'activeSubscriptions'])
                ->paginate(10);
        });

        return view('business.membership_plans.index', compact('business', 'plans'));
    }

    public function create(Business $business)
    {
        return view('business.membership_plans.form', compact('business'));
    }

    public function store(Request $request, Business $business)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'billing_cycle' => 'required|in:monthly,quarterly,yearly',
            'benefits' => 'nullable|array',
            'benefits.*' => 'string',
            'trial_days' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        DB::transaction(function () use ($business, $validated) {
            $plan = $business->membershipPlans()->create($validated);
            Cache::forget("business.{$business->id}.membership_plans");
        });

        return redirect()->route('businesses.membership_plans.index', $business)
            ->with('success', 'Membership plan created successfully.');
    }

    public function show(Business $business, MembershipPlan $plan)
    {
        $plan->load(['subscriptions' => function ($query) {
            $query->with('user')->latest();
        }]);

        return view('business.membership_plans.show', compact('business', 'plan'));
    }

    public function edit(Business $business, MembershipPlan $plan)
    {
        return view('business.membership_plans.form', compact('business', 'plan'));
    }

    public function update(Request $request, Business $business, MembershipPlan $plan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'billing_cycle' => 'required|in:monthly,quarterly,yearly',
            'benefits' => 'nullable|array',
            'benefits.*' => 'string',
            'trial_days' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        DB::transaction(function () use ($plan, $validated, $business) {
            $plan->update($validated);
            Cache::forget("business.{$business->id}.membership_plans");
        });

        return redirect()->route('businesses.membership_plans.index', $business)
            ->with('success', 'Membership plan updated successfully.');
    }

    public function destroy(Business $business, MembershipPlan $plan)
    {
        DB::transaction(function () use ($plan, $business) {
            $plan->delete();
            Cache::forget("business.{$business->id}.membership_plans");
        });

        return redirect()->route('businesses.membership_plans.index', $business)
            ->with('success', 'Membership plan deleted successfully.');
    }

    public function toggleStatus(Business $business, MembershipPlan $plan)
    {
        DB::transaction(function () use ($plan, $business) {
            $plan->update(['is_active' => !$plan->is_active]);
            Cache::forget("business.{$business->id}.membership_plans");
        });

        return back()->with('success', 'Membership plan status updated successfully.');
    }
} 