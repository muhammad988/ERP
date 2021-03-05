"use strict";
// Class definition
var KTDatatableMission = function() {
    // Private functions

    // basic demo
    var demo = function() {
        let status = {
            'true': {'title': 'true','class': ' btn-label-success'},
            'false': {'title': 'false','class': ' btn-label-danger'},
        };
        var datatable = $('.kt-datatable').KTDatatable({

            // datasource definition
            data: {

                type: 'remote',
                source: {
                    read: {
                        url: '/authority/all',
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
                    template: function(row, index, datatable) {
                        return index+1;
                    },
                },
			   {
					field: 'role',
					title: 'Role Name',
				},  {
					field: 'user',
					title: 'User',
				},  {
					field: 'project',
					title: 'Project',
				},  {
					field: 'view',
					title: 'View', template: function (row) {

                        return '<span class="btn btn-bold btn-sm btn-font-sm ' + status[row.view].class + '">' + status[row.view].title + '</span>';

                    }
				},  {
					field: 'add',
					title: 'Add', template: function (row) {
                        return '<span class="btn btn-bold btn-sm btn-font-sm ' + status[row.add].class + '">' + status[row.add].title + '</span>';

                    }
				},  {
					field: 'update',
					title: 'Update', template: function (row) {

                        return '<span class="btn btn-bold btn-sm btn-font-sm ' + status[row.update].class + '">' + status[row.update].title + '</span>';

                    }
				},  {
					field: 'disable',
					title: 'Disable', template: function (row) {
                        return '<span class="btn btn-bold btn-sm btn-font-sm ' + status[row.disable].class + '">' + status[row.disable].title + '</span>';

                    }
				},  {
					field: 'delete',
					title: 'Delete', template: function (row) {
                        return '<span class="btn btn-bold btn-sm btn-font-sm ' + status[row.delete].class + '">' + status[row.delete].title + '</span>';

                    }
				}, {
                    field: 'Actions',
                    title: 'Actions',
                    sortable: false,
                    width: 110,
                    overflow: 'visible',
                    autoHide: false,
                    template: function(data) {
                        return `
<button href="#" onclick="action_delete(${data.id})"  data-form-type="action-edit"  data-id="${data.id}"  class="btn btn-sm btn-clean btn-icon btn-icon-md test" title="Edit details">
								<i class="la la-trash"></i>
							</button>
							<button href="#" onclick="action_edit(${data.id})"  data-toggle="modal"  data-form-type="action-edit"  data-id="${data.id}"  class="btn btn-sm btn-clean btn-icon btn-icon-md test" title="Edit details">
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
        init: function() {
            demo();
        },
    };
}();

jQuery(document).ready(function() {
    KTDatatableMission.init();
});
