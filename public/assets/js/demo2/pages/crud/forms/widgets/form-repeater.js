// Class definition
let KTFormRepeater = function () {
    // Private functions
    let demo1 = function () {
        $('#kt_repeater_1').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function () {
                $(this).slideDown();
            },

            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });
    };
    let demo2 = function () {
        $('.kt_repeater_2').repeater({
            initEmpty: false,
            show: function () {
                $(this).slideDown();
            },
            hide: function (deleteElement) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        $(this).slideUp(deleteElement);
                    }
                })

            }
        });
    };
    let demo3 = function () {
        $('#kt_repeater_3').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function () {
                $(this).slideDown();
            },

            hide: function (deleteElement) {
                if (confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement);
                }
            }
        });
    };
    let demo4 = function () {
        $('#kt_repeater_4').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function () {
                $(this).slideDown();
            },

            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });
    };
    let demo5 = function () {
        $('#kt_repeater_5').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function () {
                $(this).slideDown();
            },

            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });
    };
    let demo6 = function () {
        $('#kt_repeater_6').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function () {
                $(this).slideDown();
            },

            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });
    };
    let demo7 = function () {

        $('.kt_repeater').repeater({

            initEmpty: false,

            defaultValues: {
                'personnel[0][duration]': 'foo'
            },

            show: function () {
                $(this).slideDown();
                $(this).find(".unit_cost").inputmask({
                    "alias": "decimal",
                    "digits": 4,
                    "suffix": " $",
                    "autoGroup": true,
                    "allowMinus": true,
                    "rightAlign": false,
                    autoUnmask: true,
                    "groupSeparator": ",",
                    "radixPoint": ".",

                });
                $(this).find(".total_one_budget").inputmask({
                    "alias": "decimal",
                    "digits": 4,
                    "suffix": " $",
                    "autoGroup": true,
                    "allowMinus": true,
                    "rightAlign": false,
                    autoUnmask: true,
                    "groupSeparator": ",",
                    "radixPoint": ".",
                });
                $(this).find(".chf").inputmask({
                    "rightAlign": false,
                    'alias': 'numeric',
                    "min":1,
                    "max":100,
                    "suffix": " %",
                    autoUnmask: true,
                });
                $(this).find(".quantity").inputmask({
                    'alias': 'numeric',
                    "rightAlign": false,
                    autoUnmask: true,
                });
                $(this).find(".duration").inputmask({
                    'alias': 'numeric',
                    "rightAlign": false,
                    autoUnmask: true,

                });
                $(this).find(".budget_line").inputmask({
                    'alias': 'numeric',
                    "rightAlign": false,
                    autoUnmask: true,

                });
                $(this).find('.select2-multiple').select2();
            },
            hide: function (deleteElement) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        let el =$(this).find(".total_one_budget")[0];
                        if(el) {
                            let ev = document.createEvent('Event');
                            ev.initEvent('change', true, false);
                            el.dispatchEvent(ev);
                        }
                        $(this).slideUp(deleteElement);

                    }
                })
            }

        });

    };
    let service = function () {
        $('.kt_repeater_service').repeater({
            initEmpty: false,
             // isFirstItemUndeletable: true,
            show: function () {
                $(this).slideDown();
                $('#add').addClass('disabled');
                if ($("#budget_line_hidden").val()==1){
                    $(".detailed_proposal_budget_id_dev").hide();
                    $(".availability_dev").hide();
                    $(".detailed_proposal_budget_id").removeAttr('required');
                }else{

                    $(".detailed_proposal_budget_id_dev").show();
                    $(".detailed_proposal_budget_id").attr('required', true);
                    $(".availability_dev").show();
                }
                $(this).find('.detailed_proposal_budget_id').empty();
                $(this).find('.detailed_proposal_budget_id').append($('.detailed_proposal_budget_id_hidden').html());
                $(this).find('.select2-multiple').select2();
            },
            hide: function (deleteElement) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        let el =$(this).find(".total")[0];
                        if(el){
                            let ev = document.createEvent('Event');
                            ev.initEvent('change', true, false);
                            el.dispatchEvent(ev);
                        }

                        $(this).slideUp(deleteElement);
                    }
                })

            }

        });

    };
    let service_holder = function () {
        $('.kt_repeater_service_holder').repeater({
            initEmpty: false,
             // isFirstItemUndeletable: true,
            show: function () {
                $(this).slideDown();
                $('#add').addClass('disabled');
                if ($("#budget_line_hidden").val()==1){
                    $(".detailed_proposal_budget_id_dev").hide();
                    $(".availability_dev").hide();
                    $(".detailed_proposal_budget_id").removeAttr('required');
                }else{

                    $(".detailed_proposal_budget_id_dev").show();
                    $(".detailed_proposal_budget_id").attr('required', true);
                    $(".availability_dev").show();
                }
                $(this).find('.project_id').empty();
                $(this).find('.project_id').append($('.project_id_hidden').html());
                $(this).find('.select2-multiple').select2();
                $(this).find('.kt_datepicker_3').datepicker({
                    rtl: KTUtil.isRTL(),
                    todayBtn: "linked",
                    clearBtn: true,
                    todayHighlight: true,
                });
            },
            hide: function (deleteElement) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        let el =$(this).find(".total")[0];
                        if(el){
                            let ev = document.createEvent('Event');
                            ev.initEvent('change', true, false);
                            el.dispatchEvent(ev);
                        }

                        $(this).slideUp(deleteElement);
                    }
                })

            }

        });

    };
    let clearance = function () {
        $('.kt_repeater_clearance').repeater({
            initEmpty: false,
             // isFirstItemUndeletable: true,
            show: function () {
                $(this).slideDown();
                $('#add').addClass('disabled');
                if ($("#budget_line_hidden").val()==1){
                    $(".detailed_proposal_budget_id_dev").hide();
                    $(".availability_dev").hide();
                    $(".detailed_proposal_budget_id").removeAttr('required');
                }else{

                    $(".detailed_proposal_budget_id_dev").show();
                    $(".detailed_proposal_budget_id").attr('required', true);
                    $(".availability_dev").show();
                }
                $(this).find('.detailed_proposal_budget_id').empty();
                $(this).find('.detailed_proposal_budget_id').append($('.detailed_proposal_budget_id_hidden').html());
                $(this).find('.select2-multiple').select2();
                $(this).find('.kt_datepicker_3').datepicker({
                    rtl: KTUtil.isRTL(),
                    todayBtn: "linked",
                    clearBtn: true,
                    todayHighlight: true,
                });
                $(this).find(".money-2").inputmask({
                    "alias": "decimal",
                    "digits": 4,
                    "autoGroup": true,
                    "allowMinus": true,
                    "rightAlign": false,
                    autoUnmask: true,
                    "groupSeparator": ",",
                    "radixPoint": ".",

                });
                $(this).find(".money").inputmask({
                    "alias": "decimal",
                    "digits": 4,
                    "autoGroup": true,
                    "allowMinus": true,
                    "rightAlign": false,
                    autoUnmask: true,
                    "groupSeparator": ",",
                    "radixPoint": ".",

                });
            },
            hide: function (deleteElement) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        let el =$(this).find(".total")[0];
                        if(el){
                            let ev = document.createEvent('Event');
                            ev.initEvent('change', true, false);
                            el.dispatchEvent(ev);
                        }

                        $(this).slideUp(deleteElement);
                    }
                })

            }

        });

    };
    let office_clearance = function () {
        $('.kt_repeater_office_clearance').repeater({
            initEmpty: false,
             // isFirstItemUndeletable: true,
            show: function () {
                $(this).slideDown();
                $(this).find('.select2-multiple').select2();
                $(this).find('.kt_datepicker_3').datepicker({
                    rtl: KTUtil.isRTL(),
                    todayBtn: "linked",
                    clearBtn: true,
                    todayHighlight: true,
                });
                $(this).find(".money-2").inputmask({
                    "alias": "decimal",
                    "digits": 4,
                    "autoGroup": true,
                    "allowMinus": true,
                    "rightAlign": false,
                    autoUnmask: true,
                    "groupSeparator": ",",
                    "radixPoint": ".",

                });
                $(this).find(".money").inputmask({
                    "alias": "decimal",
                    "digits": 4,
                    "autoGroup": true,
                    "allowMinus": true,
                    "rightAlign": false,
                    autoUnmask: true,
                    "groupSeparator": ",",
                    "radixPoint": ".",

                });
            },
            hide: function (deleteElement) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        // let el =$(this).find(".total")[0];
                        // if(el){
                        //     let ev = document.createEvent('Event');
                        //     ev.initEvent('change', true, false);
                        //     el.dispatchEvent(ev);
                        // }

                        $(this).slideUp(deleteElement);
                    }
                })

            }

        });

    };
    let hq_payment = function () {
        $('.kt_repeater_hq_payment').repeater({
            initEmpty: false,
             // isFirstItemUndeletable: true,
            show: function () {
                $(this).slideDown();
                $(this).find('.kt_datepicker_3').datepicker({
                    rtl: KTUtil.isRTL(),
                    todayBtn: "linked",
                    clearBtn: true,
                    todayHighlight: true,
                });
                // $(this).find(".money-2").inputmask({
                //     "alias": "decimal",
                //     "digits": 4,
                //     "autoGroup": true,
                //     "allowMinus": true,
                //     "rightAlign": false,
                //     autoUnmask: true,
                //     "groupSeparator": ",",
                //     "radixPoint": ".",
                //
                // });
                $(this).find(".money").inputmask({
                    "alias": "decimal",
                    "digits": 4,
                    "autoGroup": true,
                    "allowMinus": true,
                    "rightAlign": false,
                    autoUnmask: true,
                    "groupSeparator": ",",
                    "radixPoint": ".",

                });
            },
            hide: function (deleteElement) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        // let el =$(this).find(".total")[0];
                        // if(el){
                        //     let ev = document.createEvent('Event');
                        //     ev.initEvent('change', true, false);
                        //     el.dispatchEvent(ev);
                        // }

                        $(this).slideUp(deleteElement);
                    }
                })

            }

        });

    };
    let vacancy = function () {
        $('.kt_repeater_vacancy').repeater({
            initEmpty: false,
             // isFirstItemUndeletable: true,
            show: function () {
                $(this).slideDown();
                $(this).find('.kt_datepicker_3').datepicker({
                    rtl: KTUtil.isRTL(),
                    todayBtn: "linked",
                    clearBtn: true,
                    todayHighlight: true,
                });
                $(this).find(".money").inputmask({
                    "alias": "decimal",
                    "digits": 4,
                    "autoGroup": true,
                    "allowMinus": true,
                    "rightAlign": false,
                    autoUnmask: true,
                    "groupSeparator": ",",
                    "radixPoint": ".",

                });
                $(this).find('.select2-new').select2();
            },
            hide: function (deleteElement) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        // let el =$(this).find(".total")[0];
                        // if(el){
                        //     let ev = document.createEvent('Event');
                        //     ev.initEvent('change', true, false);
                        //     el.dispatchEvent(ev);
                        // }

                        $(this).slideUp(deleteElement);
                    }
                })

            }

        });

    };
    return {
        // public functions
        init: function () {
            demo1();
            demo2();
            demo3();
            demo4();
            demo5();
            demo6();
            demo7();
            service();
            vacancy();
            clearance();
            service_holder();
            office_clearance();
            hq_payment();
        }
    };
}();

jQuery(document).ready(function () {
    KTFormRepeater.init();
});

