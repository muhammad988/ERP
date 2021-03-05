<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" {{ (app()->getLocale() == 'ar') ? 'style=direction:rtl' : null}}>
<!-- begin::Head -->
<head>
    <meta charset="utf-8"/>
    <title>Metronic | Dashboard</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--begin::Fonts -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families": ["Poppins:300,400,500,600,700"]},
            active: function () {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <!--end::Fonts -->
    <!--begin::Page Vendors Styles(used by this page) -->
@yield('style')
<!--end::Page Vendors Styles -->

    <!--begin::Global Theme Styles(used by all pages) -->
{!! Html::style('assets/vendors/general/bootstrap-daterangepicker/daterangepicker.css') !!}
{!! Html::style('assets/vendors/custom/vendors/line-awesome/css/line-awesome.css') !!}
{!! Html::style('assets/vendors/custom/vendors/flaticon/flaticon.css') !!}
{!! Html::style('assets/vendors/custom/vendors/flaticon2/flaticon.css') !!}
{!! Html::style('assets/vendors/custom/vendors/fontawesome5/css/all.min.css') !!}
{!! Html::style('assets/vendors/general/perfect-scrollbar/css/perfect-scrollbar.css') !!}
{!! Html::style('assets/media/logos/favicon.ico',['type'=>'image/x-icon']) !!}
{!! Html::style('assets/vendors/general/toastr/build/toastr.css') !!}
<!--end::Global Theme Styles -->
    <!--begin::Global Theme Styles(used by all pages) -->
    @if(app()->getLocale() == 'ar')
        {!! Html::style('assets/demo/demo2/base/style.bundle.rtl.css') !!}
    @else
        {!! Html::style('assets/css/demo2/style.bundle.css') !!}
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <!--end::Global Theme Styles -->
</head>
<!-- end::Head -->
<!-- begin::Body -->
<body class="kt-page--loading-enabled kt-page--loading kt-page--fixed kt-header--fixed kt-header--minimize-topbar kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-page--loading">
<!-- begin::Page loader -->
<!-- end::Page Loader -->
<!-- begin:: Page -->
<!-- begin:: Header Mobile -->
@include('layouts.include.header_mobile')
<!-- end:: Header Mobile -->
<div class="kt-grid kt-grid--hor kt-grid--root">
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper " id="kt_wrapper">
            <!-- begin:: Header -->
        @include('layouts.include.header')
        <!-- end:: Header -->
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-grid--stretch">
                <div class="kt-container kt-body  kt-grid kt-grid--ver" id="kt_body">
                    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">
                        <!-- begin:: Content Head -->
                    @include('layouts.include.content_head')
                    <!-- end:: Content Head -->
                        <!-- begin:: Content -->
                    @yield('content')
                    <!-- end:: Content -->
                    </div>
                </div>
            </div>
            <!-- begin:: Footer -->
        @include('layouts.include.footer')
        <!-- end:: Footer -->
        </div>
    </div>
</div>
<!-- end:: Page -->
<!-- begin::Scroll top -->
<div id="kt_scrolltop" class="kt-scrolltop">
    <i class="fa fa-arrow-up"></i>
</div>
<!-- end::Scroll top -->
<!-- begin::Global Config(global config for global JS scripts) -->
<script type="text/javascript">
    let KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#374afb",
                "light": "#ffffff",
                "dark": "#282a3c",
                "primary": "#5867dd",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "danger": "#fd3995"
            },
            "base": {
                "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
                "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
            }
        }
    };
</script>
<!-- end::Global Config -->
<!--begin::Global Script (used by all pages) -->
{!! Html::script('assets/vendors/general/jquery/dist/jquery.js') !!}
{!! Html::script('assets/vendors/general/popper.js/dist/umd/popper.js') !!}
{!! Html::script('assets/vendors/general/bootstrap/dist/js/bootstrap.min.js') !!}
{!! Html::script('assets/vendors/general/js-cookie/src/js.cookie.js') !!}
{!! Html::script('assets/vendors/general/moment/min/moment.min.js') !!}
{!! Html::script('assets/vendors/general/tooltip.js/dist/umd/tooltip.min.js') !!}
{!! Html::script('assets/vendors/general/perfect-scrollbar/dist/perfect-scrollbar.js') !!}
{!! Html::script('assets/vendors/general/sticky-js/dist/sticky.min.js') !!}
{!! Html::script('assets/vendors/general/wnumb/wNumb.js') !!}
{!! Html::script('assets/vendors/general/bootstrap-daterangepicker/daterangepicker.js') !!}
{!! Html::script('assets/demo/demo2/base/scripts.bundle.js') !!}
{!! Html::script('assets/js/demo2/pages/components/extended/toastr.js') !!}
{!! Html::script('assets/vendors/general/toastr/build/toastr.min.js') !!}
{{--{!! Html::script('/assets/app/custom/general/components/portlets/tools.js') !!}--}}
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    function submit_form(btn, form) {
        let button = $(`#${btn}`);
        button.on('click', function () {
            KTApp.progress(button);
            button.attr('disabled', true);
            button.addClass('disabled');
            $(`#${form}`).submit();

        });
    }
    function function_delete(url) {
        swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, timer!',
            reverseButtons: true
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    url: `${url}`,
                    type: 'POST',
                    data: {_method: 'delete'},
                    dataType: 'json',
                    success: function (data) {
                        let datatable = $('.kt-datatable').KTDatatable();
                        datatable.reload();
                        swal.fire(
                            'Deleted!',
                            data['deleted'],
                            'success'
                        )

                    },
                    error: function (data) {
                        swal.fire(
                            'Cancelled!',
                            data.responseJSON['delete']['0'],
                            'error'
                        );

                    }
                });
            } else if (result.dismiss === 'cancel') {
                swal.fire(
                    'Cancelled!',
                    'Your item is safe :)',
                    'error'
                )
            }
        });

    }
    function nested(id_send, id_receipt, nested_url) {
        $(`#${id_send}`).change(function () {
            let dropdown = $(`#${id_receipt}`);
            dropdown.empty();
            let val = $(this).val();

            $.ajax({
                url: nested_url,
                method: 'POST',
                data: {id: val},
                success: function (data) {
                    if (id_receipt != 'project_officer') {
                        dropdown.append($('<option></option>').attr('value', '').text('Please Select'));
                    }
                    $.each(data, function (i, item) {
                        dropdown.append($('<option></option>').attr('value', i).text(item));
                    });
                    if (id_receipt == 'project_officer') {
                        $('.kt-selectpicker-2').selectpicker('destroy');
                        $(".kt-selectpicker-2").selectpicker({
                            noneSelectedText: 'Please Select' // by this default 'Nothing selected' -->will change to Please Select
                        });
                    }
                },
                error: function () {
                    dropdown.append($('<option></option>').attr('value', '').text('Please Select'));

                }
            });

        });

    }
    function get_sum(sum_class, total_class) {
        $(`.${sum_class}`).change(function () {
            let sum = 0;
            $(`.${sum_class}`).each(function () {
                if ($(this).val() != '') {
                    sum += Number($(this).val().replace(/,/g, ''));
                }
            });
            $(`.${total_class}`).val(sum);

        });
    }
    function get_duration(start_date, end_date, duration) {
        $(`#${start_date},#${end_date}`).change(function () {
            let start = $(`#${start_date}`).val();
            let end = $(`#${end_date}`).val();
            console.log(start);
            console.log(end);
            if (start != '' && end != '') {
                $.ajax({
                    type: "POST",
                    url: '{{route("duration")}}',
                    data: {"start_date": start, "end_date": end},
                    success: function (data) {
                        $(`#${duration}`).val(data);
                    }
                })
            } else {
                $(`#${duration}`).val(null);
            }
        })


    }
</script>
<!--end::Global Script -->
<!--begin::Page Vendors(used by this page) -->
@yield('script')
<script>

    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    // Daterangepicker Init
    let daterangepickerInit = function () {
        if ($('#kt_dashboard_daterangepicker').length == 0) {
            return;
        }

        let picker = $('#kt_dashboard_daterangepicker');
        let start = moment();
        let end = moment();

        function cb(start, end, label) {
            let title = '';
            let range = '';

            if ((end - start) < 100 || label == 'Today') {
                title = 'Today:';
                range = start.format('MMM D');
            } else if (label == 'Yesterday') {
                title = 'Yesterday:';
                range = start.format('MMM D');
            } else {
                range = start.format('MMM D') + ' - ' + end.format('MMM D');
            }
            // console.log(range);
            $('#kt_dashboard_daterangepicker_date').html(range);
            $('#kt_dashboard_daterangepicker_title').html(title);
        }

        picker.daterangepicker({
            direction: KTUtil.isRTL(),
            startDate: start,
            endDate: end,
            opens: 'left',
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end, '');
    };
    // init daterangepicker
    daterangepickerInit();
    $(document).ready(function () {
        $('div#kt_header_menu').removeClass("kt-menu__item--here");
        let path = window.location.href.replace("#", "");
        let target = $(`div#kt_header_menu a[href="${path}"]`).parents();
        target.addClass("kt-menu__item--here");
    });
</script>
<!--end::Page Vendors -->
<!--begin::Global Script (used by all pages) -->
{!! Html::script('assets/app/bundle/app.bundle.js') !!}
<!--end::Global Script -->
</body>
<!-- end::Body -->
</html>
