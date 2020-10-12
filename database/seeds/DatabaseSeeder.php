<?php

use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use App\Models\Element;
use App\Constants\StatusCode;

use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        DB::table('status')->insert(
            [
                'name' => 'Optin Form',
                'code' => 'optin_form',
                'color' => '#dd00dd',
                'type' => 2,
                'position' => 0,
            ]

        );
//        Element::truncate();
//        \App\Models\Element::truncate();
//        \App\Models\PackageWallet::truncate();
//        DB::table('package_wallets')->insert(
//            [
//                'name' => 'Gói 30 triệu nhận 40 triệu',
//                'order_price' => 30000000,
//                'price' => 40000000,
//            ]
//
//        );
//        DB::table('package_wallets')->insert(
//            [
//                'name' => 'Gói 50 triệu nhận 65 triệu',
//                'order_price' => 50000000,
//                'price' => 65000000,
//            ]
//        );
//        DB::table('package_wallets')->insert(
//            ['name' => 'Gói 70 triệu nhận 90 triệu',
//                'order_price' => 70000000,
//                'price' => 90000000,
//            ]
//        );
//        DB::table('elements')->insert([
//            'title' => 'Tạo đơn',
//            'type'  => 'event',
//            'value'  => 'add_order',
//            'color' => '#40bfc1'
//        ]);
//        DB::table('elements')->insert([
//            'title' => 'Chuyển trang thái KH',
//            'type'  => 'event',
//            'value'  => 'change_relation',
//            'color' => '#ff0100'
//        ]);
//
//        DB::table('elements')->insert([
//            'title' => 'Nhóm dịch vụ',
//            'type'  => 'actor',
//            'value'  => 'customer',
//            'color' => '#4d4646'
//        ]);
//        DB::table('elements')->insert([
//            'title' => 'Trạng thái KH',
//            'type'  => 'actor',
//            'value'  => 'staff',
//            'color' => '#5f6caf'
//        ]);
//        DB::table('elements')->insert([
//            'title' => 'Tổng hợp nhóm -- trạng thái',
//            'type'  => 'actor',
//            'value'  => 'staff_customer',
//            'color' => '#5fceef'
//        ]);

//        $value = [
//            '1. SP Tế bào gốc',
//            '2. SP Hồng bikini',
//            '3. SP Dưỡng da',
//            '4. SP Sữa rửa mặt',
//            '5. SP Trị Hôi Nách',
//            '6. SP Trị thâm',
//            '7. SP Nước rửa vệ sinh',
//            '8. SP Trị Mụn',
//            '9. SP Tiêm',
//            '10. SP Tẩy da chểt',
//            '11. SP Viên uống nám',
//            '12. SP Tắm trắng',
//            '13. SP Dầu gội',
//            '14. SP giảm béo',
//            '15. SP Thâm Nách',
//            '16. Sp Dụng cụ',
//            '17. SP Trị Nám',
//            '18. SP Viên uống',
//            '19. SP Dưỡng mi',
//            '20. SP Trị Viêm Nang Lông',
//        ];

//        foreach ($value as $item) {
//            DB::table('categories')->insert([
//                'code' => str_replace(' ', '_', strtolower($item)),
//                'type' => StatusCode::PRODUCT,
//                'name' => $item,
//            ]);
//        }

//        DB::table('elements')->insert([
//            'title' => 'Thêm ',
//            'type'  => 'event',
//            'value'  => 'edit',
//            'color' => '#db3056'
//        ]);
//        DB::table('elements')->insert([
//            'title' => 'Thêm mới hoặc chỉnh sửa',
//            'type'  => 'event',
//            'value'  => 'update',
//            'color' => '#f17362'
//        ]);

//        DB::table('elements')->insert([
//            'title' => 'Gửi SMS',
//            'type'  => 'action',
//            'value'  => 'send_sms',
//            'color' => '#ffcc00'
//        ]);
//        DB::table('elements')->insert([
//            'title' => 'Gửi Email',
//            'type'  => 'action',
//            'value'  => 'send_email',
//            'color' => '#be9fe1'
//        ]);
//        DB::table('elements')->insert([
//            'title' => 'Tạo CV',
//            'type'  => 'action',
//            'value'  => 'create_job',
//            'color' => '#03a9f4'
//        ]);
//        Model::reguard();
    }
}
