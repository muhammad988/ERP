"use strict";
// Class definition

let KTDatatableAutoColumnHideDemo = function () {
    // Private functions
    // basic demo
    let demo = function () {

        let datatable = $('.kt-datatable').KTDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: `/payment-order/list/${$('#id').val()}`,
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

                },{
                    field: 'service_type',
                    title: 'Service Type',
                    textAlign: 'center',

                },{
                    field: 'service_method',
                    title: 'Service method',
                    textAlign: 'center',

                },{
                    field: 'payment_method',
                    title: 'Payment Method',
                    textAlign: 'center',

                },
                // {
                //     field: 'project',
                //     title: 'Project',
                //     textAlign: 'center',
                //
                // },
                {
                    field: 'Service Total',
                    title: 'total',
                    textAlign: 'center',
                    template: function (row, index) {
                        let budget = '';
                         budget=`<span class="money-2"> ${row.total} </span>`;

                        return budget;

                    },


                }, {
                    field: 'currency_type',
                    title: 'Currency Type',
                    textAlign: 'center',



                },

                {
                    field: 'date',
                    title: 'Date',
                    type: 'date',
                    textAlign: 'center',

                },
                {
                    field: 'status',
                    title: 'Status',
                    textAlign: 'center',
                    // callback function support for column rendering
                    template: function (row) {
                        let status = {
                            174: { 'class': 'kt-badge--info'},
                            170: { 'class': 'kt-badge--success'},
                            171: { 'class': 'kt-badge--danger'},
                            4: { 'class': 'success'},
                            5: { 'class': 'success'},
                            182424: {'class': 'success'},
                        };
                        return '<span class="kt-badge ' + status[row.status_id].class + ' kt-badge--inline kt-badge--pill">' + row.status + '</span>';

                        // return '<span class="kt-badge ' + status[row.status_id].class + ' kt-badge--inline kt-badge--pill"></span>&nbsp;<span class="kt-font-bold kt-font-' + status[row.status_id].class + '">' +
                        //     row.status + '</span>';
                    },
                },
                {
                    field: 'Actions',
                    title: 'Actions',
                    sortable: false,
                    overflow: 'visible',
                    autoHide: false,
                    template: function (data) {
                        return `<div class="dropdown">
								<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown">
	                                <i class="la la-ellipsis-h"></i>
	                            </a>
							    <div class="dropdown-menu dropdown-menu-right">
<!--							        <a class="dropdown-item"  href="/clearance/${data.id}"><i class="la la-money"></i>Clearance</a>-->
							        <a class="dropdown-item"  href="/service/cycle/${data.id}"><i class="la la-money"></i>Cycle</a>
                                    <a  class="dropdown-item"   href="/print/pyo/${data.id}"><i class="la la-print"></i>Print</a>
							    </div>
							</div>

`;
                    },
                }
            ],

        });

        $('#kt_form_search').on('click', function () {
            // datatable.setDataSourceParam('mission_ids', $('#kt_form_mission').val());
            // datatable.setDataSourceParam('department_ids', $('#kt_form_department').val());
            // datatable.setDataSourceParam('sector_ids', $('#kt_form_sector').val());
            // datatable.setDataSourceParam('stage_ids', $('#kt_form_stage').val());
            datatable.setDataSourceParam('status_ids', $('#kt_form_status').val());
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
            $(".money-2").inputmask({
                "alias": "decimal",
                "digits": 2,
                "autoGroup": true,
                "allowMinus": true,
                "rightAlign": false,
                "groupSeparator": ",",
                "radixPoint": "."
            });
        });
    };
    // var eventsWriter = function(string) {
    //     var console = $('#kt_datatable_console').append(string + '\t\n');
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
