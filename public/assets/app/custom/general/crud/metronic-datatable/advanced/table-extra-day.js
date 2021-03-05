"use strict";
// Class definition
let KTDatatableMission = function () {
    // Private functions

    // basic demo
    let demo = function () {

        let datatable = $('.kt-datatable').KTDatatable({

            // datasource definition
            data: {

                type: 'remote',
                source: {
                    read: {
                        url: '/leave/extra-day/all',
                    },
                },
                pageSize: 10, // display 10 records per page
                saveState: true,
                serverPaging: true,
                serverFiltering: true,
                serverSorting: true,
            },
            // layout definition
            layout: {
                scroll: true, // enable/disable datatable scroll both horizontal and vertical when needed.
            },
            pagination: true,

            search: {
                input: $('#generalSearch'),
                delay: 400,
            },

            // columns definition
            columns: [
                {
                    field: 'id',
                    title: '#',
                    width: 40,
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
                    title: 'Name En',
                    textAlign: 'center',
                }, {
                    field: 'date',
                    title: 'Date',
                    textAlign: 'center',
                }, {
                    field: 'start_time',
                    title: 'Start Time',
                    textAlign: 'center',
                }, {
                    field: 'end_time',
                    title: 'End Time',
                    textAlign: 'center',
                }, {
                    field: 'number_of_minutes',
                    title: 'Number Of Hours',
                    textAlign: 'center',
                }, {
                    field: 'number_of_days',
                    title: 'Number Of Days',
                    textAlign: 'center',
                }, {
                    field: 'Actions',
                    title: 'Actions',
                    width: 110,
                    sortable: false,
                    textAlign: 'center',
                    template: function (data) {
                        return `<button href="#" onclick="action_delete(${data.id})" data-id="${data.id}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit details">
								<i class="la la-trash"></i>
							</button>
							<button href="#" onclick="action_edit(${data.id})" data-id="${data.id}"  class="btn btn-sm btn-clean btn-icon btn-icon-md test" title="Edit details">
								<i class="la la-edit"></i>
							</button>`;
                    },
                }],

        });
        $('#user_id').on('change', function() {
                datatable.search($(this).val(), 'user_id');
        });

        $('#position_id').on('change', function() {
            datatable.search($(this).val(), 'position_id');
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
    KTDatatableMission.init();
});
