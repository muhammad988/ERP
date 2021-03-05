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
                        url: `/hr/fingerprint-user/day/${$('#user_id').val()}`,
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
                    template: function (row, index) {

                        return index + 1;
                    },
                },
                {
                    field: 'financial_code',
                    title: 'Financial Code',
                    textAlign: 'center',

                },
                {
                    field: 'user_full_name_en',
                    title: 'Name EN',
                    textAlign: 'center',

                },{
                    field: 'user_full_name_ar',
                    title: 'Name AR',
                    textAlign: 'center',

                }, {
                    field: 'time',
                    title: 'Time',
                    textAlign: 'center',

                }, {
                    field: 'device',
                    title: 'Device',
                    textAlign: 'center',

                }, {
                    field: 'state',
                    title: 'State',
                    textAlign: 'center',


                }, {
                    field: 'Actions',
                    title: 'Actions',
                    width: 110,
                    sortable: false,
                    textAlign: 'center',
                    template: function (row) {
                        return `<button href="#" onclick="action_delete(${row.id})" data-id="${row.id}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit details">
								<i class="la la-trash"></i>
							</button>
							<button href="#" onclick="action_edit(${row.id})" data-id="${row.id}"  class="btn btn-sm btn-clean btn-icon btn-icon-md test" title="Edit details">
								<i class="la la-edit"></i>
							</button>`;
                    },
                }
            ],

        });

        $('#kt_form_search').on('click', function () {
            datatable.setDataSourceParam('department_ids', $('#kt_form_department').val());
            datatable.setDataSourceParam('center_ids', $('#kt_form_center').val());
            datatable.setDataSourceParam('project_ids', $('#kt_form_project').val());
            datatable.setDataSourceParam('position_ids', $('#kt_form_position').val());
                datatable.setDataSourceParam('search', $('#generalSearch').val());
            if ($('#kt_form_start_date').val() != '') {
                datatable.setDataSourceParam('start_date', $('#kt_form_start_date').val());
            }
            if ($('#kt_form_end_date').val() != '') {
                datatable.setDataSourceParam('end_date', $('#kt_form_end_date').val());
            }
            datatable.reload();
        });

    };

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
