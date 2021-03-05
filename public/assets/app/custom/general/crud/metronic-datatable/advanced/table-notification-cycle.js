"use strict";
// Class definition
var KTDatatableMission = function() {
    // Private functions

    // basic demo
    var demo = function() {

        var datatable = $('.kt-datatable').KTDatatable({

            // datasource definition
            data: {

                type: 'remote',
                source: {
                    read: {
                        url: '/hr/control-panel/notification-cycle/all',
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
					field: 'name_en',
					title: 'Name',
				},  {
					field: 'notification_receiver',
					title: 'Notification Receiver',
				},  {
					field: 'notification_type',
					title: 'Notification Type',
				},  {
					field: 'number_of_superiors',
					title: 'Number Of Superiors',
				},  {
					field: 'group_number',
					title: 'Group Number',
				},  {
					field: 'authorized',
					title: 'Authorized',
                    template: function (row) {
                        let status = {
                            'true': {'class': 'kt-badge--success'},
                            'false': {'class': 'kt-badge--danger'},

                        };
                        return '<span class="kt-badge ' + status[row.authorized].class + ' kt-badge--inline kt-badge--pill">' + row.authorized + '</span>';

                        // return '<span class="kt-badge ' + status[row.status_id].class + ' kt-badge--inline kt-badge--pill"></span>&nbsp;<span class="kt-font-bold kt-font-' + status[row.status_id].class + '">' +
                        //     row.status + '</span>';
                    },
				}, {
                    field: 'Actions',
                    title: 'Actions',
                    sortable: false,
                    width: 110,
                    overflow: 'visible',
                    autoHide: false,
                    template: function(data) {
                        return `<button href="#" onclick="action_delete(${data.id})"  data-form-type="action-edit"  data-id="${data.id}"  class="btn btn-sm btn-clean btn-icon btn-icon-md test" title="Edit details">
								<i class="la la-trash"></i>
							</button>
							<button href="#" onclick="action_edit(${data.id})"  data-toggle="modal"  data-form-type="action-edit"  data-id="${data.id}" data-target="#edit" class="btn btn-sm btn-clean btn-icon btn-icon-md test" title="Edit details">
								<i class="la la-edit"></i>
							</button>`;
                    },
                }],

        });
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
