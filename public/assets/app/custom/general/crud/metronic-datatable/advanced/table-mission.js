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
                        url: '/hr/control-panel/mission/all',
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
                    field: 'parent',
                    title: 'Parent',
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
                        return `<div class="dropdown">
								<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown">
	                                <i class="la la-ellipsis-h"></i>
	                            </a>
							    <div class="dropdown-menu dropdown-menu-right">
							        <a class="dropdown-item"  href="/hr/control-panel/mission/budget/${data.id}"><i class="la la-eye"></i>List Budget</a>
							        <a class="dropdown-item"  href="/hr/control-panel/mission/budget/create/${data.id}"><i class="la la-plus"></i>Add Budget</a>
							    </div>
							</div>
							<button  onclick="action_delete(${data.id})"  data-form-type="action-edit"  data-id="${data.id}" data-target="#edit_mission" class="btn btn-sm btn-clean btn-icon btn-icon-md test" title="Edit details">
								<i class="la la-trash"></i>
							</button>
							<button  onclick="action_edit(${data.id})"  data-toggle="modal"  data-form-type="action-edit"    class="btn btn-sm btn-clean btn-icon btn-icon-md test" title="Edit details">
								<i class="la la-edit"></i>
							</button>
							<a href="/hr/control-panel/mission/management/${data.id}"    class="btn btn-sm btn-clean btn-icon btn-icon-md">
								<i class="la la-gear"></i>
							</a>`;
                    },
                }],

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
