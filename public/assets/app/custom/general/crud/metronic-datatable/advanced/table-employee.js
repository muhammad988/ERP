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
                        url: '/hr/employee/all',
                    },
                },
                pageSize: 10,
                saveState: false,
                serverPaging: true,
                serverFiltering: true,
                serverSorting: true,
            },

            layout: {
                scroll: true,
                height: 710,
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
                    field: 'photo',
                    title: '#',
                    width:'60',
                    autoHide: false,
                    template: function (data) {
                        let output = '';
                        if (data.photo !== null) {
                            output = '<div class="kt-user-card-v2">\
								<div class="kt-user-card-v2__pic">\
									<img src="/images/user/' + data.photo + '" alt="photo">\
								</div>\
								<div class="kt-user-card-v2__details">\
									<span class="kt-user-card-v2__name"></span>\
									<a href="#" class="kt-user-card-v2__email kt-link"></a>\
								</div>\
							</div>';
                        } else {
                            let stateNo = KTUtil.getRandomInt(0, 7);
                            let states = [
                                'success',
                                'brand',
                                'danger',
                                'success',
                                'warning',
                                'dark',
                                'primary',
                                'info'];
                            let state = states[stateNo];

                            output = '<div class="kt-user-card-v2">\
								<div class="kt-user-card-v2__pic">\
									<div class="kt-badge kt-badge--xl kt-badge--' + state + '"></div>\
								</div>\
								<div class="kt-user-card-v2__details">\
									<span class="kt-user-card-v2__name"></span>\
									<a href="#" class="kt-user-card-v2__email kt-link"></a>\
								</div>\
							</div>';
                        }
                        return output;
                    },
                }, {
                    field: 'first_name_en',
                    title: 'Name EN',
                    autoHide: false,
                }, {
                    field: 'first_name_ar',
                    title: 'Name AR',
                    autoHide: false,
                }, {
                    field: 'position_name',
                    title: 'Position',
                    autoHide: false,
                }, {
                    field: 'mission_name',
                    title: 'Mission',
                    autoHide: false,
                }, {
                    field: 'start_date',
                    title: 'Start Date',
                    type: 'date',
                    autoHide: false,
                }, {
                    field: 'end_date',
                    title: 'End Date',
                    type: 'date',
                    autoHide: false,
                }, {
                    field: 'disabled',

                    title: 'Status',
                    autoHide: false,
                    // callback function support for column rendering
                    template: function (row) {
                        let status = {
                            0: {'title': 'Active', 'state': 'success'},
                            1: {'title': 'Inactive', 'state': 'danger'},
                        };
                        return '<span class="kt-badge kt-badge--' + status[row.disabled] + ' kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-' + status[row.disabled].state + '">' +
                            status[row.disabled].title + '</span>';
                    },
                }, {
                    field: 'email',
                    title: 'Email',
                    autoHide: true,

                }, {
                    field: 'nationality_name',
                    title: 'Nationality',
                    autoHide: true,

                }, {
                    field: 'basic_salary',
                    title: 'Basic Salary',
                    autoHide: true,

                }, {
                    field: 'gross_salary',
                    title: 'Gross Salary',
                    autoHide: true,

                }, {
                    field: 'working_hours',
                    title: 'Number Of Working Hours',
                    autoHide: true,

                }, {
                    field: 'gender',
                    title: 'Gender',
                    autoHide: true,

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
							        <a class="dropdown-item"  href="/hr/employee/${data.id}"><i class="la la-eye"></i>View</a>
							        <a class="dropdown-item"  onclick="action_status(${data.id})" href="javascript:;"><i class="la la-power-off"></i>Status</a>
							    </div>
							</div>
							<a href="/hr/employee/${data.id}/edit" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit details">
								<i class="la la-edit"></i>
							</a>`;
                    },
                }
            ],

        });

        $('#kt_form_search').on('click', function () {
            datatable.setDataSourceParam('mission', $('#kt_form_mission').val());
            datatable.setDataSourceParam('department', $('#kt_form_department').val());
            datatable.setDataSourceParam('project', $('#kt_form_project').val());
            datatable.setDataSourceParam('contract', $('#kt_form_contract').val());
            datatable.setDataSourceParam('type_of_contract', $('#kt_form_type_of_contract').val());
            datatable.setDataSourceParam('position', $('#kt_form_position').val());
            datatable.setDataSourceParam('nationality', $('#kt_form_nationality').val());
            if ($('#kt_form_start_date').val() != '') {
                datatable.setDataSourceParam('start_date', $('#kt_form_start_date').val());
            }
            if ($('#kt_form_end_date').val() != '') {
                datatable.setDataSourceParam('end_date', $('#kt_form_end_date').val());
            }
            if ($('#kt_form_disabled').val() != '') {
                datatable.setDataSourceParam('disabled', $('#kt_form_disabled').val());
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
