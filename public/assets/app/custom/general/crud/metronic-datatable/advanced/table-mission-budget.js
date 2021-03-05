"use strict";
// Class definition
var KTDatatableMission = function () {
    // Private functions

    // basic demo
    var demo = function () {

        var datatable = $('.kt-datatable').KTDatatable({

            // datasource definition
            data: {

                type: 'remote',
                source: {
                    read: {
                        url: `/hr/control-panel/mission/budget/all/${$('#mission_id').val()}`,
                    },
                },
                pageSize: 10, // display 20 records per page
                serverPaging: true,
                saveState: false,

                serverFiltering: true,
                serverSorting: true,
            },

            // layout definition
            layout: {
                scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
                footer: false, // display/hide footer
            },

            // column sorting
            sortable: false,

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
                    field: 'name_en',
                    title: 'name en',
                }, {
                    field: 'name_ar',
                    title: 'name ar',
                }, {
                    field: 'start_date',
                    title: 'Start Date',
                }, {
                    field: 'end_date',
                    title: 'End Date',
                }, {
                    field: 'Actions',
                    title: 'Actions',
                    sortable: false,
                    overflow: 'visible',
                    autoHide: false,
                    template: function (data) {
                        return `<a href="/hr/control-panel/mission/budget/edit/${data.id}"    title="Edit" class="btn btn-sm btn-clean btn-icon btn-icon-md">
								<i class="la la-edit"></i>
							</a>	<a href="/hr/control-panel/mission/budget/show/${data.id}"  title="View"   class="btn btn-sm btn-clean btn-icon btn-icon-md">
								<i class="la la-eye"></i>
							</a>`;
                    },
                }],

        });

        $('#kt_form_status').on('change', function () {
            datatable.search($(this).val().toLowerCase(), 'Status');
            datatable.reload();
        });

        $('#kt_form_type').on('change', function () {
            datatable.search($(this).val().toLowerCase(), 'Type');
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
