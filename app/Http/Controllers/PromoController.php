<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Auth;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function apply(Request $request)
    {
        $promoCode = $request->input('promo_code');
        $promo = Promo::where('code', $promoCode)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        if (!$promo) {
            return back()->with('promo_error', 'Invalid or expired promo code.');
        }

        if ($promo->user()->where('user_id', Auth::id())->wherePivot('used', true)->exists()) {
            return back()->with('promo_error', 'You have already used this promo code.');
        }

        // Calculate discount
        $totalPrice = $request->totalPrice;
        if ($promo->type === 'percentage') {
            $discount = $totalPrice * ($promo->discount / 100);
        } elseif ($promo->type === 'fixed') {
            $discount = $promo->discount;
        } else {
            $discount = 0;
        }

        // Ensure the discount doesn't exceed the total price
        $discountedPrice = max(0, $totalPrice - $discount);

        return back()->with('promo_success', 'Promo code applied successfully!');
    }

}
