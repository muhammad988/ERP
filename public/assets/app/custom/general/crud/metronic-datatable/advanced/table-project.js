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
                        url: '/project/all',

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
                    field: 'name_en',
                    title: 'Name EN',
                    textAlign: 'center',

                }, {
                    field: 'code',
                    title: 'Code',
                    textAlign: 'center',

                }, {
                    field: 'budget',
                    title: 'Budget',
                    textAlign: 'center',
                    template: function (row, index) {
                        let budget = '';
                        budget = `<span class="currency"> ${row.budget} </span>`;

                        return budget;

                    },


                }, {
                    field: 'donors',
                    title: 'Donor',
                    textAlign: 'center',
                    template: function (row) {
                        let donor = '';
                        $.each(row.donors, function (key, value) {
                            if (key == 0) {
                                donor = `<h6 > ${value.name_en} </h6>`;
                            } else {
                                donor += `<h6 > ${value.name_en} </h6>`;

                            }
                        });

                        return donor;
                    },

                }, {
                    field: 'mission',
                    title: 'Mission',
                    textAlign: 'center',

                },
                // {
                //     field: "AgentName",
                //     title: "Assigned",
                //     textAlign: 'center',
                //
                //     // callback function support for column rendering
                //     template: function(data, i) {
                //         var number = 4 + i;
                //         while (number > 12) {
                //             number = number - 3;
                //         }
                //         var user_img = '100_' + number + '.jpg';
                //
                //         var pos = KTUtil.getRandomInt(0, 5);
                //         var position = [
                //             'Developer',
                //             'Designer',
                //             'CEO',
                //             'Manager',
                //             'Architect',
                //             'Sales'
                //         ];
                //
                //         var output = '';
                //         if (number > 5) {
                //             output = '<div class="kt-user-card-v2">\
                // 				<div class="kt-user-card-v2__pic">\
                // 					<img src="https://keenthemes.com/metronic/preview/assets/media/users/' + user_img + '" alt="photo">\
                // 				</div>\
                // 				<div class="kt-user-card-v2__details">\
                // 					<a href="#" class="kt-user-card-v2__name">' + data.id + '</a>\
                // 					<span class="kt-user-card-v2__desc">' + position[pos] + '</span>\
                // 				</div>\
                // 			</div>';
                //         } else {
                //             var stateNo = KTUtil.getRandomInt(0, 6);
                //             var states = [
                //                 'success',
                //                 'brand',
                //                 'danger',
                //                 'success',
                //                 'warning',
                //                 'primary',
                //                 'info'
                //             ];
                //             var state = states[stateNo];
                //
                //             output = '<div class="kt-user-card-v2">\
                // 				<div class="kt-user-card-v2__pic">\
                // 					<div class="kt-badge kt-badge--xl kt-badge--' + state + '">' + data.id + '</div>\
                // 				</div>\
                // 				<div class="kt-user-card-v2__details">\
                // 					<a href="#" class="kt-user-card-v2__name">' + data.id + '</a>\
                // 					<span class="kt-user-card-v2__desc">' + position[pos] + '</span>\
                // 				</div>\
                // 			</div>';
                //         }
                //
                //         return output;
                //     }
                // },
                {
                    field: 'stage',
                    title: 'Stage',
                    textAlign: 'center',

                    // callback function support for column rendering
                    template: function (row) {
                        let status = {
                            1: {'state': 'success'},
                            2: {'state': 'success'},
                            3: {'state': 'success'},
                            4: {'state': 'success'},
                            5: {'state': 'success'},
                            182424: {'state': 'success'},
                        };
                        return '<span class="kt-badge kt-badge--' + status[row.stage_id] + ' kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-' + status[row.stage_id].state + '">' +
                            row.stage + '</span>';
                    },
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
                    field: 'status',
                    title: 'Status',
                    textAlign: 'center',

                    // callback function support for column rendering
                    template: function (row) {
                        let status = {
                            174: {'class': 'kt-badge--info'},
                            170: {'class': 'kt-badge--success'},
                            171: {'class': 'kt-badge--danger'},
                            4: {'class': 'success'},
                            5: {'class': 'success'},
                            182424: {'class': 'success'},
                        };
                        return '<span class="kt-badge ' + status[row.status_id].class + ' kt-badge--inline kt-badge--pill">' + row.status + '</span>';

                        // return '<span class="kt-badge ' + status[row.status_id].class + ' kt-badge--inline kt-badge--pill"></span>&nbsp;<span class="kt-font-bold kt-font-' + status[row.status_id].class + '">' +
                        //     row.status + '</span>';
                    },
                },
                {
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
							        <a class="dropdown-item"  href="${view_url}"><i class="la la-eye"></i>View</a>
							        <a class="dropdown-item"  href="/project/cycle/${data.id}"><i class="la la-group"></i>Cycle</a>
							        <a class="dropdown-item"  href="/project/responsibility/${data.id}"><i class="la la-cog"></i>Responsibility</a>
							        <a class="dropdown-item"  href="/project/donor-management/${data.id}"><i class="la la-cog"></i>Donor Management</a>
							        <a class="dropdown-item"  href="/project/donor-payment-request/${data.id}"><i class="la la-cog"></i>Donor Payment Request</a>
							        <a class="dropdown-item"  href="/project/attach-file/${data.id}"><i class="la la-folder"></i>Attach File</a>
							        <a class="dropdown-item"  href="/project/print/${data.id}"><i class="la la-print"></i>Print</a>
							        <a class="dropdown-item"  href="/project/index-budget-line/${data.id}"><i class="la la-users"></i>Payroll</a>
							        <a class="dropdown-item"  href="/payroll/project_vacancy/${data.id}"><i class="la la-user-plus"></i>Vacancy</a>
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
