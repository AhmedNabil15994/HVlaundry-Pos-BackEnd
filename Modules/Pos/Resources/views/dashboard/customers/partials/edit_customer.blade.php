<div id="kt_update_customer" class="bg-body drawer drawer-end" data-kt-drawer="true" data-kt-drawer-name="update_customer" data-kt-drawer-activate="true"
     data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'300px', 'lg': '600px'}" data-kt-drawer-direction="end"
     data-kt-drawer-toggle="#kt_update_customer_toggle" data-kt-drawer-close="#kt_update_customer_close">

    <div class="card shadow-none border-0 rounded-0">
        <!--begin::Header-->
        <div class="card-header" id="kt_update_customer_header">
            <h3 class="card-title fw-bold text-gray-900">Customer Details</h3>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5" id="kt_update_customer_close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </button>
            </div>
        </div>
        <!--end::Header-->

        <!--begin::Body-->
        <div class="card-body position-relative" id="kt_update_customer_body">
            <!--begin::Content-->
            <div id="kt_update_customer_scroll" class="position-relative scroll-y me-n5 pe-5" data-kt-scroll="true" data-kt-scroll-height="auto"
                 data-kt-scroll-wrappers="#kt_update_customer_body" data-kt-scroll-dependencies="#kt_update_customer_header, #kt_update_customer_footer" data-kt-scroll-offset="5px">
                <!--begin::Timeline items-->
                <div class="timeline timeline-border-dashed">
                    <!--begin::Timeline item-->
                    <div class="timeline-item">
                        <!--begin::Timeline line-->
                        <div class="timeline-line"></div>
                        <!--end::Timeline line-->

                        <!--begin::Timeline icon-->
                        <div class="timeline-icon">
                            <i class="ki-duotone ki-pencil fs-2 text-gray-500">
                                <span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span>
                            </i>
                        </div>
                        <!--end::Timeline icon-->

                        <!--begin::Timeline content-->
                        <div class="timeline-content mb-10 mt-n1">
                            <!--begin::Timeline heading-->
                            <div class="mb-5 pe-3">
                                <!--begin::Title-->
                                <a href="#" class="fs-5 fw-semibold text-gray-800 text-hover-primary mb-2">Basic Info:</a>
                                <!--end::Title-->
                            </div>
                            <!--end::Timeline heading-->

                            <!--begin::Timeline details-->
                            <div class="overflow-auto pb-5">
                                <div class="border border-dashed border-gray-300 rounded min-w-450px p-5">
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7 col-12 clearSelection">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Name</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid" placeholder="Name" name="name" value="" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7 col-12 clearSelection">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold mb-2">
                                            <span class="required">Email</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="hidden" name="customer_id">
                                        <input type="email" class="form-control form-control-solid" placeholder="Email" name="email" value="" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7 col-12 clearSelection">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Phone</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="tel" class="form-control form-control-solid" placeholder="Phone" name="mobile" value="" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7 col-12 clearSelection">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Password</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="password" class="form-control form-control-solid" placeholder="Password" name="password" value="" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-15 col-12 clearSelection">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Password Confirmation</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="password" class="form-control form-control-solid" placeholder="Password Confirmation" name="password_confirmation" value="" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                            </div>
                            <!--end::Timeline details-->
                        </div>
                        <!--end::Timeline content-->
                    </div>
                    <!--end::Timeline item-->
                </div>
                <!--end::Timeline items-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Body-->

        <!--begin::Footer-->
        <div class="card-footer py-5 text-center" id="kt_update_customer_footer">
            <a href="#" class="btn btn-bg-body update_customer w-100" style="color: #FFF;background: #764fa8">
                Update Customer
                <i class="ki-duotone ki-arrow-right fs-3 text-white"><span class="path1"></span><span class="path2"></span></i>
            </a>
        </div>
        <!--end::Footer-->
    </div>
</div>

@push('extra_scripts')
    <script>
        "use strict";
        // On document ready
        KTUtil.onDOMContentLoaded(function () {

            $(document).on('click','.edit_customer',function (e){
                e.preventDefault();e.stopPropagation();
                let customer_id = $(this).data('area');
                $.ajax({
                    type: "GET",
                    url: '{{route('dashboard.users.getOne',['id'=>':id'])}}'.replace(':id',customer_id),
                    success:function (data){
                        if(data[0]){
                            let userObj = data[1];
                            clearFormData();
                             $('#kt_update_customer input[name="name"]').val(userObj.name),
                               $('#kt_update_customer input[name="email"]').val(userObj.email),
                                 $('#kt_update_customer input[name="mobile"]').val(userObj.mobile),
                                   $('#kt_update_customer input[name="customer_id"]').val(customer_id);

                            $('#kt_update_customer').addClass('drawer-on')
                        }else{
                            errorMessage(data[1])
                        }
                    },
                    error:function (error){
                        errorMessage(error[1])
                    }
                })
            });

            $(document).on('click','.update_customer',function (e){
                e.preventDefault();e.stopPropagation();
                let customer_id = $('#kt_update_customer input[name="customer_id"]').val();
                $.ajax({
                    type: 'PUT',
                    url: "{{route('dashboard.users.update',['id'=>":id"])}}".replace(':id',customer_id),
                    data:{
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'name': $('#kt_update_customer input[name="name"]').val(),
                        'email': $('#kt_update_customer input[name="email"]').val(),
                        'mobile': $('#kt_update_customer input[name="mobile"]').val(),
                        'password': $('#kt_update_customer input[name="password"]').val(),
                        'password_confirmation': $('#kt_update_customer input[name="password_confirmation"]').val(),
                    },
                    success:function (data){
                        successMessage(data[1])
                        $('#kt_update_customer_close').click()
                        $('#kt_update_customer input[name="customer_id"]').val('');
                        clearFormData();
                        let myEditTable = new $.fn.dataTable.Api( '#kt_customers_table' );
                        myEditTable.ajax.reload();
                    },
                    error:function (error){
                        $.each(error.responseJSON.errors ,function (index,item){
                            errorMessage(item[0])
                        })
                    }
                })
            });
        });

    </script>
@endpush
