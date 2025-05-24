<?php

view()->composer([
    'area::dashboard.cities.*',
    'order::dashboard.shared._filter',
    'order::vendor.shared._filter',
    'user::dashboard.addresses._create_modal',
    'pos::dashboard.customers.partials.add_customer',
    'pos::dashboard.customers.partials.add_address',
    'pos::dashboard.orders.partials.product_details',
], \Modules\Area\ViewComposers\Dashboard\CountryComposer::class);

view()->composer(
    [
        'area::dashboard.states.*',
        'company::dashboard.delivery-charges.*',
        'vendor::dashboard.delivery-charges.*',
        'vendor::dashboard.vendors.*',
        'order::dashboard.shared._filter',
        'order::vendor.shared._filter',
        'pos::dashboard.customers.partials.add_customer',
        'pos::dashboard.customers.partials.add_address',
        'pos::dashboard.orders.partials.product_details',
    ],
    \Modules\Area\ViewComposers\Dashboard\CityComposer::class
);

view()->composer(
    [
        'coupon::dashboard.*',
        'user::dashboard.drivers.create',
        'user::dashboard.drivers.edit',
        'pos::dashboard.customers.partials.add_customer',
        'pos::dashboard.customers.partials.add_address',
        'pos::dashboard.orders.partials.product_details',
    ],
    \Modules\Area\ViewComposers\Dashboard\CityWithStatesComposer::class
);

view()->composer([
    'order::dashboard.shared._filter',
    'order::vendor.shared._filter',
    'pos::dashboard.customers.partials.add_customer',
    'pos::dashboard.customers.partials.add_address',
    'report::dashboard.reports._partial.subscriptions',
    'pos::dashboard.orders.partials.product_details',
], \Modules\Area\ViewComposers\Dashboard\StateComposer::class);

view()->composer(
    [
        'vendor::frontend.vendors.*',
        'pos::dashboard.customers.partials.add_customer',
        'pos::dashboard.customers.partials.add_address',
        'pos::dashboard.orders.partials.product_details',
        // 'user::frontend.profile.*',
    ],
    \Modules\Area\ViewComposers\FrontEnd\StateComposer::class
);

view()->composer(
    [
        'catalog::frontend.address.*',
        'catalog::frontend.address.index',
        'user::frontend.profile.addresses.address',
        'user::frontend.profile.addresses.create',
        'pos::dashboard.customers.partials.add_customer',
        'pos::dashboard.customers.partials.add_address',
        'catalog::frontend.checkout.*',
        'pos::dashboard.orders.partials.product_details',
    ],
    \Modules\Area\ViewComposers\FrontEnd\CityComposer::class
);

view()->composer(
    [
        'catalog::frontend.address.*',
        'catalog::frontend.address.index',
        'user::frontend.profile.addresses.address',
        'user::frontend.profile.addresses.create',
        'catalog::frontend.checkout.*',
        'pos::dashboard.customers.partials.add_customer',
        'pos::dashboard.customers.partials.add_address',
        'pos::dashboard.orders.partials.product_details',
    ],
    \Modules\Area\ViewComposers\FrontEnd\StateComposer::class
);

view()->composer(
    [
        'catalog::frontend.address.*',
        'catalog::frontend.address.index',
        'user::frontend.profile.addresses.address',
        'user::frontend.profile.addresses.create',
        'pos::dashboard.customers.partials.add_customer',
        'catalog::frontend.checkout.*',
        'pos::dashboard.customers.partials.add_address',
        'pos::dashboard.orders.partials.product_details',
    ],
    \Modules\Area\ViewComposers\FrontEnd\CountryComposer::class
);

view()->composer(
    [
        'pos::dashboard.customers.partials.add_customer',
        'area::dashboard.shared._area_tree',
        'pos::dashboard.customers.partials.add_address',
        'pos::dashboard.orders.partials.product_details',
        'pos::dashboard.orders.partials.filter_orders',
    ],
    \Modules\Area\ViewComposers\Dashboard\AreaComposer::class
);

view()->composer(
    [
        'order::frontend.orders.partial._create_address',
        'user::frontend.profile.index',
        'pos::dashboard.customers.partials.add_address',
        'pos::dashboard.customers.partials.add_customer',
        'pos::dashboard.orders.partials.product_details',
    ],
    \Modules\Area\ViewComposers\FrontEnd\CityWithStatesDeliveryComposer::class
);
