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
                        url: `/report/budget-category-data/${$('#project_id').val()}`,
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
                    field: 'budget_category',
                    title: 'Budget Category',
                    textAlign: 'center',
                    template: function (row, index) {
                        let code = '';
                        code = `<span title=" ${row.project_name}"> ${row.budget_category} </span>`;

                        return code;

                    },

                }, {
                    field: 'total_budget',
                    title: 'Budget',
                    textAlign: 'center',
                    sortable: false,

                    template: function (row, index) {
                        let budget = '';
                        budget = `<span class="currency"> ${row.total_budget} </span>`;

                        return budget;

                    },


                }, {
                    field: 'expense',
                    title: 'Expense',
                    textAlign: 'center',
                    sortable: false,

                    template: function (row, index) {
                        let budget = '';
                        budget = `<span class="currency"> ${row.expense} </span>`;

                        return budget;

                    },

                }, {
                    field: 'remaining',
                    title: 'Remaining',
                    textAlign: 'center',
                    sortable: false,

                    template: function (row, index) {
                        let budget = '';
                        budget = `<span class="currency"> ${row.remaining} </span>`;

                        return budget;

                    },


                },
                {
                    field: 'received',
                    title: 'Reserved',
                    textAlign: 'center',
                    sortable: false,

                    template: function (row, index) {
                        let budget = '';
                        budget = `<span class="currency"> ${row.received} </span>`;

                        return budget;

                    },


                },  {
                    field: 'usable',
                    title: 'Usable',
                    textAlign: 'center',
                    sortable: false,

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
<!--							        <a class="dropdown-item"  href="/report/budget-category/${data.project_id}"><i class="la la-eye"></i>Budget Category</a>-->
							        <a class="dropdown-item"  href="/report/budget/${data.project_id}/${data.budget_category_id}"><i class="la la-eye"></i>Budget Line</a>
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
