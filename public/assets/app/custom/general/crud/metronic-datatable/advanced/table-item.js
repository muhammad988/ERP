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
                        url: '/project/control-panel/item/all',
                    },
                },
                pageSize: 10, // display 10 records per page
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
                    title: 'Name En',
                }, {
                    field: 'name_ar',
                    title: 'Name Ar',
                }, {
                    field: 'item_category',
                    title: 'Item Category',
                }, {
                    field: 'Actions',
                    title: 'Actions',
                    sortable: false,
                    width: 110,
                    overflow: 'visible',
                    autoHide: false,
                    template: function (data) {
                        return `<button href="#" onclick="action_delete(${data.id})" data-id="${data.id}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit details">
								<i class="la la-trash"></i>
							</button>
							<button href="#" onclick="action_edit(${data.id})" data-toggle="modal" data-id="${data.id}" data-target="#edit" class="btn btn-sm btn-clean btn-icon btn-icon-md test" title="Edit details">
								<i class="la la-edit"></i>
							</button>`;
                    },
                }],

        });

        // $('#kt_form_status').on('change', function() {
        //         datatable.search($(this).val().toLowerCase(), 'Status');
        //         datatable.reload();
        // });
        //
        // $('#kt_form_type').on('change', function() {
        //     datatable.search($(this).val().toLowerCase(), 'Type');
        // });
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
