<?php

return [
    'coupons' => [
        'datatable' => [
            'code' => 'Code',
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'expired_at' => 'Expired at',
            'image' => 'Image',
            'options' => 'Options',
            'status' => 'Status',
            'title' => 'Title',
            'orders_count' => 'Orders Count',
            'balance'   => 'Balance',
        ],
        'form' => [
            'categories' => 'Categories',
            'code' => 'Code',
            'description' => 'Brief description',
            'discount_percentage' => 'Discount Percentage',
            'discount_type' => 'Discount type',
            'discount_value' => 'Discount Value',
            'end_at' => 'End at',
            'expired_at' => 'Expired at',
            'image' => 'Image',
            'max_discount_percentage_value' => 'Max discount percentage value',
            'max_users' => 'Maximum number of users',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'packages' => 'Packages',
            'percentage' => 'Percentage',
            'products' => 'Products',
            'start_at' => 'Start at',
            'status' => 'Status',
            'tabs' => [
                'custom' => 'Customize the discount code',
                'general' => 'General Info.',
                'seo' => 'SEO',
                'use' => 'The validity of using the discount code',
                'coupon_users_types' => 'Users Types',
            ],
            'title' => 'Title',
            'user_max_uses' => 'Maximum user usage',
            'users' => 'Users',
            'value' => 'Value',
            'vendors' => 'Vendors',
            'all_products' => 'All Products',
            'select2_coupon_users_placeholder' => 'All Users',
            'coupon_users_hint' => 'The coupon will be applied to all users if no users are specified',
            'free_delivery' => 'Free Delivery',
            'user_type' => [
                'user' => 'Client',
                'guest' => 'Guest',
                'both' => 'Both',
            ],
            'all_users' => 'All Users',
            'tooltips' => [
                'user_max_uses_tooltip' => 'It is applied to registered customers only',
            ],
            'states' => 'States',
            'all_states' => 'All States',
            'users_count' => 'Users Count',
        ],
        'routes' => [
            'clone' => 'Clone coupons',
            'create' => 'Create coupons',
            'index' => 'coupons',
            'update' => 'Update coupons',
            'recharge_coupons' => 'Recharge Coupons',
        ],
        'validation' => [
            'code' => [
                'required' => 'Please select discount code',
                'unique' => 'This code is taken before',
            ],
            'discount_type' => [
                'required' => 'Please select discount type',
            ],
            'discount_value' => [
                'required_if' => 'Please enter discount value',
            ],
            'discount_percentage' => [
                'required_if' => 'Please enter discount percentage',
            ],
            'coupon_flag' => [
                'required' => 'Please select coupon type',
                'in' => 'coupon type in:vendors,categories,products',
            ],
            'vendor_ids' => [
                'required_if' => 'Please select vendors',
            ],
            'category_ids' => [
                'required_if' => 'Please select categories',
            ],
            'product_ids' => [
                'required_if' => 'Please select products',
            ],
            'start_at' => [
                'required' => 'Please enter start at date',
                'date_format' => 'Enter the start date in Y-m-d format',
                'after_or_equal' => 'The start date must be greater than or equal to today\'s date',
            ],
            'expired_at' => [
                'required' => 'Please enter expired at date',
                'date_format' => 'Enter the expiration date in Y-m-d format',
                'after' => 'The expiration date must be greater than or equal to today\'s date',
            ],
        ],
    ],
];
