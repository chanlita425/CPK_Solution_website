<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coupon;
use Carbon\Carbon;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        $coupons = [
            [
                'code' => 'WELCOME10',
                'type' => 'percent',
                'value' => 10.00,
                'min_order_amount' => 50.00,
                'is_active' => true,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonths(3),
            ],
            [
                'code' => 'SAVE20',
                'type' => 'percent',
                'value' => 20.00,
                'min_order_amount' => 100.00,
                'is_active' => true,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonths(6),
            ],
            [
                'code' => 'FLAT50',
                'type' => 'fixed',
                'value' => 50.00,
                'min_order_amount' => 200.00,
                'is_active' => true,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonths(1),
            ],
            [
                'code' => 'SUMMER25',
                'type' => 'percent',
                'value' => 25.00,
                'min_order_amount' => 150.00,
                'is_active' => true,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonths(2),
            ],
            [
                'code' => 'FREESHIP',
                'type' => 'fixed',
                'value' => 10.00,
                'min_order_amount' => 80.00,
                'is_active' => true,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonths(4),
            ],
            [
                'code' => 'EXPIRED2024',
                'type' => 'percent',
                'value' => 15.00,
                'min_order_amount' => 0.00,
                'is_active' => false,
                'start_date' => Carbon::now()->subMonths(6),
                'end_date' => Carbon::now()->subMonths(3),
            ],
            [
                'code' => 'BLACKFRIDAY',
                'type' => 'percent',
                'value' => 30.00,
                'min_order_amount' => 300.00,
                'is_active' => false,
                'start_date' => Carbon::now()->subMonths(2),
                'end_date' => Carbon::now()->subMonths(1),
            ],
            [
                'code' => 'WEEKEND15',
                'type' => 'percent',
                'value' => 15.00,
                'min_order_amount' => 0.00,
                'is_active' => true,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addWeeks(2),
            ],
        ];

        foreach ($coupons as $coupon) {
            Coupon::create($coupon);
        }
    }
}
