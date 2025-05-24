<!--begin::Javascript-->
<script>var hostUrl = "{{asset('/pos/assets/')}}";</script>

<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{asset('/pos/assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('/pos/assets/js/scripts.bundle.js')}}"></script>
<!--end::Global Javascript Bundle-->

<!--begin::Vendors Javascript(used for this page only)-->
<script src="{{asset('/pos/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js')}}"></script>
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
<script src="{{asset('/pos/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<!--end::Vendors Javascript-->

<!--begin::Custom Javascript(used for this page only)-->
<script src="{{asset('/pos/assets/js/widgets.bundle.js')}}"></script>
<script src="{{asset('/pos/assets/js/custom/widgets.js')}}"></script>
<script src="{{asset('/pos/assets/js/custom/apps/chat/chat.js')}}"></script>
<script src="{{asset('/pos/assets/js/custom/utilities/modals/create-campaign.js')}}"></script>
<script src="{{asset('/pos/assets/js/custom/utilities/modals/upgrade-plan.js')}}"></script>
<script src="{{asset('/pos/assets/js/custom/utilities/modals/users-search.js')}}"></script>
<!--end::Custom Javascript-->

<!--end::Javascript-->

<script>

    function clearFormData(){
        $('.clearSelection input,.clearSelection select,.clearSelection textarea').val('')
        $('.clearSelection input[type="checkbox"]').prop('checked',false)
    }

    function successMessage(message){
        const container = document.getElementById('kt_docs_toast_stack_container');
        const targetElement = document.querySelector('[data-kt-docs-toast="stack"]');
        targetElement.parentNode.removeChild(targetElement);

        const newToast = targetElement.cloneNode(true);
        newToast.querySelector('.toast-header').classList.remove('bg-danger');
        newToast.querySelector('.toast-header').classList.add('bg-success');
        newToast.querySelector('.toast-header').classList.add('text-white');
        newToast.querySelector('.toast-body').innerHTML = message;
        container.append(newToast);
        const toast = bootstrap.Toast.getOrCreateInstance(newToast);
        toast.show();
    }

    function errorMessage(message){
        const container = document.getElementById('kt_docs_toast_stack_container');
        const targetElement = document.querySelector('[data-kt-docs-toast="stack"]');
        targetElement.parentNode.removeChild(targetElement);

        const newToast = targetElement.cloneNode(true);
        newToast.querySelector('.toast-header').classList.remove('bg-success');
        newToast.querySelector('.toast-header').classList.add('bg-danger');
        newToast.querySelector('.toast-header').classList.add('text-white');
        newToast.querySelector('.toast-body').innerHTML = message;
        container.append(newToast);
        const toast = bootstrap.Toast.getOrCreateInstance(newToast);
        toast.show();
    }

    KTUtil.onDOMContentLoaded(function () {

        $('#kt_app_sidebar_toggle').on('click',function () {
            $(this).toggleClass('active');
            $('body').attr('data-kt-app-sidebar-minimize', ( $(this).hasClass('active') ? 'off' : 'on'))
            $('.app-sidebar-logo-default').toggleClass('d-hidden');
            if(!$(this).hasClass('active')){
                $(this).css('left','40px');
            }else{
                $(this).css('left','unset');
                $(this).css('right','0');
            }
        })
    });
</script>
@stack('scripts')

@stack('extra_scripts')
