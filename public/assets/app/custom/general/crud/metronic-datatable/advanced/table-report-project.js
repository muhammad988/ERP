"use strict";
// Class definition

let KTDatatableAutoColumnHideDemo = function () {
    // Private functions
    // basic demo
    let demo = function () {
        let view_url = '';
        let edit_url = '';
        let hidden = '';
        let datatable = $('.kt-datatable').KTDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: '/report/project-data',

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
                    field: 'project_code',
                    title: 'Project Code',
                    textAlign: 'center',
                    template: function (row, index) {
                        let code = '';
                        code = `<span  data-toggle="kt-tooltip" title="${row.project_name}" data-skin="dark" data-placement="top"> ${row.project_code} </span>`;

                        return code;

                    },

                }, {
                    field: 'project_account',
                    title: 'Account  Balance',
                    textAlign: 'center',

                    template: function (row, index) {
                        let budget = '';
                        budget = `<span class="currency"> ${row.account_balance} </span>`;
                        return budget;

                    },


                }, {
                    field: 'total_budget_line',
                    title: 'Budget',
                    textAlign: 'center',

                    template: function (row, index) {
                        let budget = '';
                        budget = `<span class="currency"> ${row.total_budget_line} </span>`;
                        return budget;

                    },


                }, {
                    field: 'expense',
                    title: 'Expense',
                    textAlign: 'center',

                    template: function (row, index) {
                        let budget = '';
                        budget = `<a target="_blank" href="/service/expense/${row.project_id}"><span class="currency"> ${row.expense} </span></a>`;

                        return budget;

                    },

                }, {
                    field: 'remaining',
                    title: 'Remaining',
                    textAlign: 'center',
                    template: function (row, index) {
                        let budget = '';
                        budget = `<span class="currency"> ${row.remaining} </span>`;

                        return budget;

                    },


                },
                {
                    field: 'recerved',
                    title: 'Reserved',
                    textAlign: 'center',
                    template: function (row, index) {
                        let budget = '';
                        budget = `<a target="_blank" href="/service/reserved/${row.project_id}"><span class="currency"> ${row.recerved} </span></a>`;

                        return budget;

                    },


                },  {
                    field: 'usable',
                    title: 'Usable',
                    textAlign: 'center',
                    template: function (row, index) {
                        let budget = '';
                        budget = `<span class="currency"> ${row.usable} </span>`;

                        return budget;

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
							        <a class="dropdown-item"  href="/report/budget-category/${data.project_id}"><i class="la la-eye"></i>Budget Category</a>
<!--							        <a class="dropdown-item"  href="/report/budget/${data.project_id}"><i class="la la-eye"></i>Budget Line</a>-->
							    </div>
							</div>
							`;
                    },
                }
            ],

        });

        $('#kt_form_search').on('click', function () {
            datatable.setDataSourceParam('mission_ids', $('#kt_form_mission').val());
            datatable.setDataSourceParam('department_ids', $('#kt_form_department').val());
            datatable.setDataSourceParam('sector_ids', $('#kt_form_sector').val());
            datatable.setDataSourceParam('stage_ids', $('#kt_form_stage').val());
            datatable.setDataSourceParam('status_ids', $('#kt_form_status').val());
            if ($('#kt_form_start_date').val() != '') {
                datatable.setDataSourceParam('start_date', $('#kt_form_start_date').val());
            }
            if ($('#kt_form_end_date').val() != '') {
                datatable.setDataSourceParam('end_date', $('#kt_form_end_date').val());
            }
            if ($('#kt_form_max_budget').val() != '') {
                datatable.setDataSourceParam('max_budget', $('#kt_form_max_budget').val());
            }
            if ($('#kt_form_min_budget').val() != '') {
                datatable.setDataSourceParam('min_budget', $('#kt_form_min_budget').val());
            }
            datatable.reload();
        });

    };
    let eventsCapture = function () {
        $('.kt-datatable').on('kt-datatable--on-layout-updated', function () {
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
