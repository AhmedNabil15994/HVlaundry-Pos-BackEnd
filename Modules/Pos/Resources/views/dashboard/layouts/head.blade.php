<link rel="canonical" href="{{URL::current()}}" />

<link rel="shortcut icon" href="{{ url(config('setting.images.favicon')) }}" />

<!--begin::Fonts(mandatory for all pages)-->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
<!--end::Fonts-->

<!--begin::Vendor Stylesheets(used for this page only)-->
<link href="{{asset('/pos/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('/pos/assets/plugins/custom/datatables/datatables.bundle'.(locale() == 'ar' ? '.rtl' : '').'.css')}}" rel="stylesheet" type="text/css" />
<!--end::Vendor Stylesheets-->

<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
<link href="{{asset('/pos/assets/plugins/global/plugins.bundle'.(locale() == 'ar' ? '.rtl' : '').'.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('/pos/assets/css/style.bundle'.(locale() == 'ar' ? '.rtl' : '').'.css')}}" rel="stylesheet" type="text/css" />
<!--end::Global Stylesheets Bundle-->

<style>
    .app-default, body{
        background: #fbfbfb;
    }
    .app-header{
        background: #fefefe;
        border-bottom: 1px solid #F1F1F4;
        @if(locale() == 'ar')
        margin-right: -10px;
        @else
        margin-left: -10px;
        @endif
    }
    .app-sidebar .app-sidebar-header{
        border-bottom: 0;
    }
    #kt_app_sidebar{
        margin: 0;
        border-radius: 0;
        color: #636674;
        background: #FFF;
        @if(locale() == 'ar')
        border-left: 1px solid #F1F1F4;
        @else
        border-right: 1px solid #F1F1F4;
        @endif
    }
    .app-sidebar-header a img{
        width:100% !important;
    }
    .app-sidebar-menu .menu .menu-item .menu-link,
    .app-sidebar-menu .menu .menu-item .menu-link .menu-title,
    .app-sidebar-menu .menu .menu-item:not(.here) .menu-link:hover:not(.disabled):not(.active):not(.here) .menu-title,
    .app-sidebar-menu .menu .menu-item:not(.here) .menu-link:hover:not(.disabled):not(.active):not(.here) .menu-icon,
    .app-sidebar-menu .menu .menu-item:not(.here) .menu-link:hover:not(.disabled):not(.active):not(.here) .menu-icon i{
        color: #636674;
    }
    .app-sidebar-menu .menu .menu-item .menu-link.active,
    .app-sidebar-menu .menu .menu-item .menu-link.active .menu-title,
    .app-sidebar-menu .menu .menu-item .menu-link.active .menu-icon,
    .app-sidebar-menu .menu .menu-item .menu-link.active .menu-icon i,
    .app-sidebar-menu .menu .menu-item .menu-link:hover,
    .app-sidebar-menu .menu .menu-item .menu-link:hover .menu-title,
    .app-sidebar-menu .menu .menu-item .menu-link:hover .menu-icon,
    .app-sidebar-menu .menu .menu-item .menu-link:hover .menu-icon i,
    .app-sidebar-menu .menu .menu-item .menu-link:focus,
    .app-sidebar-menu .menu .menu-item .menu-link:focus .menu-title,
    .app-sidebar-menu .menu .menu-item .menu-link:focus .menu-icon,
    .app-sidebar-menu .menu .menu-item .menu-link:focus .menu-icon i{
        color: #764fa8 !important;
        background: #e1d8f1 !important;
    }
    .app-sidebar-menu .menu .menu-item .menu-link.active .menu-title,
    .app-sidebar-menu .menu .menu-item .menu-link.active .menu-icon,
    .app-sidebar-menu .menu .menu-item .menu-link.active .menu-icon i{
        color: #764fa8;
    }
    .menu-sub-indention .menu-item .menu-item .menu-link.active{
        margin-left: 0;
        margin-right: 0;
    }
    .text-stylish{
        color: #764fa8 !important;
    }
    .border-r-50{
        border-radius: 50%;
    }
    .border-r-0{
        border-radius: 0;
    }
    .text-decoration ,
    .text-decoration:hover,
    .text-decoration:active,
    .text-decoration:focus,
    .text-decoration.active{
        text-decoration: underline dashed !important;
    }
    .text-right{
        text-align: {{locale() == 'ar' ? 'left' : 'right'}};
    }
    .text-left{
        text-align: {{locale() == 'ar' ? 'right' : 'left'}};
    }
    .float-right{
        float: {{locale() == 'ar' ? 'left' : 'right'}};
    }
    .float-left{
        float: {{locale() == 'ar' ? 'right' : 'left'}};
    }
    .pre-line{
        white-space: pre-line;
    }
    .clearfix{
        clear:both !important;
    }
    .product-card:hover,
    .product-card:active,
    .product-card:focus,
    .product-card.active{
        border: 1px solid #764fa8;
    }
    .addon-card.active{
        background: #e1d8f1 !important;
        transition: all ease-in-out .25s;
    }
    .addon-card.active:after{
        content:"\e99f";
        font-family: keenicons-outline !important;
        width: 25px;
        height: 25px;
        border-radius: 50%;
        color: #FFF;
        background: #764fa8;
        font-size: 18px;
        position: absolute;
        top: -10px;
        @if(locale() == 'ar')
        left: -10px;
        @else
        right: -10px;
        @endif
    }
    .addon-card.active .card-body span{
        color: #000 !important;
    }
    .address_item{
        color: #764fa8;
        background: #e1d8f1;
        border-radius: 30px;
    }
    .address_item:hover,
    .address_item.active,
    .address_item:hover i,
    .address_item.active i{
        color:#FFF !important;
    }
    .cart .item-loader,
    .products-card .products-loader{
        opacity: .5;
        text-align: center;
        position: absolute;
    }
    .cart .spinner-border{
        margin-top: 300px;
    }
    .products-card .spinner-border{
        margin-top: 350px;
    }
    .d-hidden{
        display: none;
    }
    #kt_app_sidebar_toggle{
        right: 0;
        transition:  all ease-in-out .25s;
    }
    span.order_status{
        color:#FFF;
        border-radius: 25px;
        font-size:12px;
    }
    .select2-container--bootstrap5 .select2-selection--multiple:not(.form-select-sm):not(.form-select-lg) .select2-selection__choice .select2-selection__choice__display .form-check{
        padding-left: 0 !important;
    }
    .select2-container--bootstrap5 .select2-selection--multiple:not(.form-select-sm):not(.form-select-lg) .select2-selection__choice .select2-selection__choice__display .form-check-input{
        display: none;
    }
    .btn-stylish{
        border: 1px solid #764fa8 !important;
        border-radius: 5px;
    }
    #kt_filter_orders .form-check-input.btn-stylish:checked{
        background-color: #764fa8;
    }
    #kt_filter_orders .select2-container--bootstrap5 .select2-dropdown .select2-results__option.select2-results__option--selected:after{
        background-color: transparent;
    }
    #kt_filter_orders .select2-container--bootstrap5 .select2-dropdown li label,
    #kt_filter_orders .select2-container--bootstrap5 .select2-dropdown .select2-results__option{
        color: #000 !important;
    }

    #kt_filter_orders .select2-container--bootstrap5 .select2-dropdown .select2-results__option:hover,
    #kt_filter_orders .select2-container--bootstrap5 .select2-dropdown .select2-results__option:active,
    #kt_filter_orders .select2-container--bootstrap5 .select2-dropdown .select2-results__option:focus,
    #kt_filter_orders .select2-container--bootstrap5 .select2-dropdown .select2-results__option.select2-results__option--selected,
    #kt_filter_orders .select2-container--bootstrap5 .select2-dropdown .select2-results__option.select2-results__option--highlighted{
        background-color: #dfd2f0;
        color: #000 !important;
    }
    .removeCartItem:hover i{
        color: #f1416c !important;
    }
    .nav-link-border-solid.active{
        border-color: #764fa8 !important;
    }
</style>
@stack('styles')

@stack('extra_styles')
