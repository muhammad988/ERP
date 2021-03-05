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
                        url: '/leave/all',

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
                    field: 'user_full_name',
                    title: 'Name EN',
                    textAlign: 'center',

                }, {
                    field: 'leave_type_name',
                    title: 'Leave Type',
                    textAlign: 'center',

                }, {
                    field: 'position_name',
                    title: 'Position',
                    textAlign: 'center',

                }, {
                    field: 'leave_days',
                    title: 'Leave Period',
                    textAlign: 'center',

                },
                {
                    field: 'start_date',
                    title: 'Start Date',
                    type: 'date',
                    textAlign: 'center',

                }, {
                    field: 'end_date',
                    title: 'End Date',
                    type: 'date',
                    textAlign: 'center',

                },
                {
                    field: 'status_name',
                    title: 'Status',
                    textAlign: 'center',

                    // callback function support for column rendering
                    template: function (row) {
                        let status = {
                            174: {'class': 'kt-badge--warning'},
                            170: {'class': 'kt-badge--success'},
                            171: {'class': 'kt-badge--danger'},
                        };
                        return '<span class="kt-badge ' + status[row.status_id].class + ' kt-badge--inline kt-badge--pill">' + row.status_name + '</span>';

                        // return '<span class="kt-badge ' + status[row.status_id].class + ' kt-badge--inline kt-badge--pill"></span>&nbsp;<span class="kt-font-bold kt-font-' + status[row.status_id].class + '">' +
                        //     row.status + '</span>';
                    },
                }
            ],

        });

        $('#kt_form_search').on('click', function () {
            datatable.setDataSourceParam('department_ids', $('#kt_form_department').val());
            datatable.setDataSourceParam('organisation_unit_ids', $('#kt_form_organisation_unit').val());
            datatable.setDataSourceParam('status_ids', $('#kt_form_status').val());
            datatable.setDataSourceParam('project_ids', $('#kt_form_project').val());
            datatable.setDataSourceParam('position_ids', $('#kt_form_position').val());
                datatable.setDataSourceParam('search', $('#generalSearch').val());
            if ($('#kt_form_start_date').val() != '') {
                datatable.setDataSourceParam('start_date', $('#kt_form_start_date').val());
            }
            if ($('#kt_form_end_date').val() != '') {
                datatable.setDataSourceParam('end_date', $('#kt_form_end_date').val());
            }
            if ($('#kt_form_max').val() != '') {
                datatable.setDataSourceParam('max_leave_period', $('#kt_form_max').val());
            }
            if ($('#kt_form_min').val() != '') {
                datatable.setDataSourceParam('min_leave_period', $('#kt_form_min').val());
            }
            datatable.reload();
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

        },
    };
}();

jQuery(document).ready(function () {
    KTDatatableAutoColumnHideDemo.init();

});
