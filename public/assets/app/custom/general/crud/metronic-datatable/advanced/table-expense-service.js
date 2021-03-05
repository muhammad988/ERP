"use strict";
// Class definition

let KTDatatableAutoColumnHideDemo = function () {
    // Private functions
    // basic demo
    let demo = function () {
        let url;
        let hidden;
        let hidden_status;
        let code = '';
        // console.log($('#type').val());
        // console.log($('#project_id').val());
        let datatable = $('.kt-datatable').KTDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: `/service/get/${$('#type').val()}/${$('#project_id').val()}`,
                    },
                },

                pageSize: 10,
                saveState: false,
                serverPaging: true,
                serverFiltering: true,
                serverSorting: true,
            },

            layout: {
                scroll: false,
                // height: 710,
            },

            // column sorting
            sortable: true,

            pagination: true,

            search: {
                input: $('#generalSearch'),
            },

            // columns definition
            columns: [
                {
                    field: 'id',
                    title: '#',
                    width: 20,
                    type: 'number',
                    selector: false,
                    textAlign: 'center',
                    autoHide: false,
                    template: function (row, index, datatable) {
                        return index + 1;
                    },
                },
                {
                    field: 'code',
                    title: 'Service Code',
                    textAlign: 'center',
                    template: function (row, index) {
                        if (row.currency_id==87034){
                            hidden='hidden'
                        } else {
                            hidden=''
                        }
                        code=`<a href="javascript:;" class="view"  data-toggle="modal" data-target="#service-modal"  id="${row.id}"> ${row.code}  <span ${hidden} class="kt-badge kt-badge--info kt-badge--inline kt-badge--pill">${row.currency_type} </span></a>`;
                        return code;
                    }

                }
                ,{
                    field: 'requester',
                    title: 'Requester',
                    textAlign: 'center',
                    sortable: false,
                }
                // ,{
                //     field: 'service_method',
                //     title: 'Service method',
                //     textAlign: 'center',
                //     sortable: false,
                //
                // },{
                //     field: 'payment_method',
                //     title: 'Payment Method',
                //     textAlign: 'center',
                //     sortable: false,
                //
                // }
                ,{
                    field: 'total_usd',
                    title: 'Total Service',
                    textAlign: 'center',
                    template: function (row, index) {
                        let budget = '';
                         budget=`<span class="currency">${row.total_usd}</span>`;
                        return budget;
                    }
                }, {
                    field: 'c_total',
                    title: 'Total Clearance',
                    textAlign: 'center',
                    template: function (row, index) {
                        let budget = '';
                         budget=`<span class="currency">${row.c_total}</span>`;
                        return budget;
                    }
                }
                // , {
                //     field: 'currency_type',
                //     title: 'Currency Type',
                //     sortable: false,
                //     textAlign: 'center',
                // }
                ,{
                    field: 'created_at',
                    title: 'Date',
                    type: 'date',
                    textAlign: 'center',

                },
                {
                    field: 'status',
                    title: 'Close',
                    sortable: false,
                    textAlign: 'center',
                    // callback function support for column rendering
                    template: function (row) {
                        let status = {
                            false: { 'class': 'kt-badge--danger','title':'Partial Closure'},
                            true: { 'class': 'kt-badge--success','title':'Closed'},
                        };
                        if(row.total_clearance==0){
                            return '<span class="kt-badge ' + status[row.completed].class + ' kt-badge--inline kt-badge--pill">' + status[row.completed].title + '</span>';
                        }else{
                            return '<span class="kt-badge ' + status[row.completed].class + ' kt-badge--inline kt-badge--pill">' + status[row.completed].title + '</span>';

                        }
                    },
                },
                {
                    field: 'Actions',
                    title: 'Actions',
                    sortable: false,
                    overflow: 'visible',
                    autoHide: false,
                    template: function (row) {

                        if (row.status_id!=170){
                            hidden_status='hidden'
                        }else {
                            hidden_status=''
                        }
                        if (row.payment_method_id==3296 && row.service_type_id==375446){
                             url=`<a class="dropdown-item"  ${hidden_status} href="/payment-order/${row.id}"><i class="la la-list"></i>List Of Payment Order</a>`;
                        }else{
                            url=`<a class="dropdown-item"  ${hidden_status} href="/clearance/${row.id}"><i class="la la-list"></i>List Of Clearance</a>`;
                        }
                        return `<div class="dropdown">
								<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown">
	                                <i class="la la-ellipsis-h"></i>
	                            </a>
							    <div class="dropdown-menu dropdown-menu-right">
							        ${url}
							        <a class="dropdown-item"  href="/service/cycle/${row.id}"><i class="la la-money"></i>Cycle</a>
							    </div>
							</div>`;
                    },
                }
            ],

        });
        $('#kt_form_group_by').on('change', function () {
            datatable.setDataSourceParam('group_by', $('#kt_form_group_by').val());
            datatable.reload();
        });
        $('#kt_form_search').on('click', function () {
            datatable.setDataSourceParam('payment_method_ids', $('#kt_form_payment_method').val());
            datatable.setDataSourceParam('service_method_ids', $('#kt_form_service_method').val());
            datatable.setDataSourceParam('service_type_ids', $('#kt_form_service_type').val());
            datatable.setDataSourceParam('service_requester_ids', $('#kt_form_service_requester').val());
            if ($('#kt_form_close').val() != null) {
                datatable.setDataSourceParam('close', $('#kt_form_close').val());
            }
            if ($('#kt_form_start_date').val() != '') {
                datatable.setDataSourceParam('start_date', $('#kt_form_start_date').val());
            }
            if ($('#kt_form_end_date').val() != '') {
                datatable.setDataSourceParam('end_date', $('#kt_form_end_date').val());
            }
            if ($('#kt_form_max_total').val() != '') {
                datatable.setDataSourceParam('max_total', $('#kt_form_max_total').val());
            }
            if ($('#kt_form_min_total').val() != '') {
                datatable.setDataSourceParam('min_total', $('#kt_form_min_total').val());
            }
            datatable.reload();
        });

    };
    let eventsCapture = function() {
        $('.kt-datatable').on('kt-datatable--on-layout-updated', function() {
            $(".currency").inputmask({
                "alias": "decimal",
                "digits": 2,
                "suffix": " $",
                autoUnmask: true,
                removeMaskOnSubmit: true,
                "autoGroup": true,
                "allowMinus": true,
                "rightAlign": false,
                "groupSeparator": ",",
                "radixPoint": "."
            });
            $('[data-toggle="kt-tooltip"]').each(function() {
                initTooltip($(this));
            });

        });
    };
    let initTooltip = function(el) {
        let skin = el.data('skin') ? 'tooltip-' + el.data('skin') : '';
        let width = el.data('width') == 'auto' ? 'tooltop-auto-width' : '';
        let triggerValue = el.data('trigger') ? el.data('trigger') : 'hover';
        let placement = el.data('placement') ? el.data('placement') : 'left';

        el.tooltip({
            trigger: triggerValue,
            template: '<div class="tooltip ' + skin + ' ' + width + '" role="tooltip">\
                <div class="arrow"></div>\
                <div class="tooltip-inner"></div>\
            </div>'
        });
    };
    // let eventsWriter = function(string) {
    //     let console = $('#kt_datatable_console').append(string + '\t\n');
    //     $(console).scrollTop(console[0].scrollHeight - $(console).height());
    // };
    return {
        // public functions
        init: function () {
            demo();
            eventsCapture();
        },
    };
}();

jQuery(document).ready(function () {
    KTDatatableAutoColumnHideDemo.init();

});
