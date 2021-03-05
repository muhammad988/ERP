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
                        url: `/project/get-budget-line/${$('#project_id').val()}`,

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
                    field: 'budget_line',
                    title: 'Budget Line',
                    textAlign: 'center',
                },
                {
                    field: 'category_option_name',
                    title: 'Category Option Name',
                    textAlign: 'center',

                }, {
                    field: 'donor',
                    title: 'Donor',
                    textAlign: 'center',
                }, {
                    field: 'usable',
                    title: 'Usable',
                    textAlign: 'center',
                    template: function (row, index) {
                        return `<span class="currency"> ${row.total-row.remaining} </span>`;
                    },
                }, {
                    field: 'duration',
                    title: 'Duration',
                    textAlign: 'center',
                }, {
                    field: 'remaining',
                    title: 'Remaining',
                    textAlign: 'center',
                    template: function (row, index) {
                        return `<span class="currency">  ${row.remaining }  </span>`;
                    },
                }, {
                    field: 'total',
                    title: 'total',
                    textAlign: 'center',
                    template: function (row, index) {
                        return `<span class="currency"> ${row.total} </span>`;
                    },
                }, {
                    field: 'Actions',
                    title: 'Actions',
                    sortable: false,
                    overflow: 'visible',
                    autoHide: false,
                    template: function (data) {
                        if (data.stage_id==1){
                           view_url=`/project/concept/${data.id}`;
                           edit_url=`/project/concept/${data.id}/edit`;
                        }else if(data.stage_id==2){
                            view_url=`/project/submission/${data.id}`;
                            edit_url=`/project/submission/${data.id}/edit`;
                        }
                        if (data.status_id==170){
                            hidden='hidden';
                        }else{
                            hidden='';
                        }
                        return `<div class="dropdown">
								<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown">
	                                <i class="la la-ellipsis-h"></i>
	                            </a>
							    <div class="dropdown-menu dropdown-menu-right">
<!--							        <a class="dropdown-item"  href="${view_url}"><i class="la la-eye"></i>View</a>-->
							        <a class="dropdown-item"  href="/payroll/user_salary/${data.id}"><i class="la la-group"></i>User Salary</a>
							        <a class="dropdown-item"  href="/payroll/management_allowance/${data.id}"><i class="la la-group"></i>Management Allowance</a>
							        <a class="dropdown-item"  href="/payroll/transportation_allowance/${data.id}"><i class="la la-group"></i>Transportation Allowance</a>
							        <a class="dropdown-item"  href="/payroll/house_allowance/${data.id}"><i class="la la-group"></i>House Allowance</a>
							        <a class="dropdown-item"  href="/payroll/cell_phone_allowance/${data.id}"><i class="la la-group"></i>Cell Phone Allowance</a>
							        <a class="dropdown-item"  href="/payroll/cost_of_living_allowance/${data.id}"><i class="la la-group"></i>Cost Of Living Allowance</a>
							        <a class="dropdown-item"  href="/payroll/fuel_allowance/${data.id}"><i class="la la-group"></i>Fuel Allowance</a>
							        <a class="dropdown-item"  href="/payroll/appearance_allowance/${data.id}"><i class="la la-group"></i>Appearance Allowance</a>
							        <a class="dropdown-item"  href="/payroll/work_nature_allowance/${data.id}"><i class="la la-group"></i>Work Nature Allowance</a>
							       
<!--							        <a class="dropdown-item"  onclick="action_status(${data.id})" href="javascript:;"><i class="la la-power-off"></i>Status</a>-->
							    </div>
							</div>
							<a ${hidden} href="${edit_url}"  class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit details">
								<i class="la la-edit"></i>
							</a>`;
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
