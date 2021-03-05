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
                        url: '/hr/fingerprint/get-report',
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
                // height: 710,
            },

            // column sorting
            sortable: true,

            pagination: true,

            // search: {
            //     input: $('#generalSearch'),
            // },

            // columns definition
            columns: [
                {
                    field: 'financial_code',
                    title: 'الرمز المالي',
                    width: 50,
                    type: 'number',
                    selector: false,
                    textAlign: 'center',
                    autoHide: false,
                }, {
                    field: 'user_full_name_ar',
                    title: 'اسم',
                    textAlign: 'center',
                    autoHide: false,
                }, {
                    field: 'center',
                    title: 'مركز',
                    textAlign: 'center',
                    autoHide: false,
                }, {
                    field: 'position_name_ar',
                    title: 'منصب',
                    textAlign: 'center',
                    autoHide: false,
                }, {
                    field: 'start_date',
                    title: 'تاريخ',
                    textAlign: 'center',
                    autoHide: false,
                }, {
                    field: 'assumed_work_status',
                    title: 'الدوام المفترض',
                    textAlign: 'center',
                    autoHide: false,
                    template: function (row, index, datatable) {
                        return `<a href="javascript:;" class="view" onclick="action_edit(${row.id})"  data-toggle="modal" data-target="#edit"  id="${row.id}">  <span  class="kt-badge kt-badge--info kt-badge--inline kt-badge--pill"> ${row.assumed_work_status} </span></a>`;
                    },
                }, {
                    field: 'assumed_entry',
                    title: 'دخول مفترض',
                    textAlign: 'center',
                    autoHide: false,
                }, {
                    field: 'assumed_exit',
                    title: 'خروج مفترض',
                    textAlign: 'center',
                    autoHide: false,
                }, {
                    field: 'entry',
                    title: 'الدخول',
                    textAlign: 'center',
                    sortable: false,
                    autoHide: false,
                }, {
                    field: 'exit',
                    title: 'الخروج',
                    textAlign: 'center',
                    sortable: false,
                    autoHide: false,
                }, {
                    field: 'work_hours',
                    title: 'الساعات المحتسبة',
                    sortable: false,
                    textAlign: 'center',
                    autoHide: false,
                }, {
                    field: 'work_status',
                    title: 'الدوام المحتسب',
                    sortable: false,
                    textAlign: 'center',
                    autoHide: false,
                    template: function (row) {
                        // console.log(row.work_status['c']);
                        // console.log(Object.keys(row.work_status));
                        var status = {
                            d: {'class': ' kt-badge--success'},
                            b: { 'class': ' kt-badge--info'},
                            a: { 'class': ' kt-badge--danger'},
                            c: {'class': ' kt-badge--warning'},
                        };
                        if (row.work_status){
                            return '<a href="http://localhost:8000/hr/employee/fingerprint/' +row.id + '" target="_blank"> <span class="kt-badge ' + status[Object.keys(row.work_status)].class + ' kt-badge--inline' +
                                ' kt-badge--pill">' +row.work_status[Object.keys(row.work_status)] + '</span></a>';

                        }
                    },
                }
            ],

        });

        $('#kt_form_search').on('click', function () {
            datatable.setDataSourceParam('center', $('#kt_form_center').val());
            datatable.setDataSourceParam('work_status', $('#kt_form_work_status').val());
            datatable.setDataSourceParam('department', $('#kt_form_department').val());
            datatable.setDataSourceParam('project', $('#kt_form_project').val());
            datatable.setDataSourceParam('search', $('#search').val());
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
