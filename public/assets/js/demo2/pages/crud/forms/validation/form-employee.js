// Class definition

let KTFormControls = function () {
    let active_form;
    let inactive_form;
    let validator_active;
    let validator_inactive;

    let status_active = function () {
        validator_active = active_form.validate({
            ignore: ":hidden",
            // define validation rules
            rules: {
                //= Client Information(step 3)
                // Billing Information

            },

            //display error alert on form submit
            invalidHandler: function (event, validator) {
                // swal.fire({
                //     "title": "",
                //     "text": "There are some errors in your submission. Please correct them.",
                //     "type": "error",
                //     "confirmButtonClass": "btn btn-secondary",
                //     "onClose": function(e) {
                //         console.log('on close event fired!');
                //     }
                // });

                event.preventDefault();
            },

            submitHandler: function (form) {
                //form[0].submit(); // submit the form
                swal.fire({
                    "title": "",
                    "text": "Form validation passed. All good!",
                    "type": "success",
                    "confirmButtonClass": "btn btn-secondary"
                });

                return false;
            }
        });
    };
    $('#parent').on('change', function () {
        validator_inactive.element($('#parent')); // validate element
    });
    let status_inactive = function () {
        validator_inactive = inactive_form.validate({
            ignore: ":hidden",
            // define validation rules
            rules: {
                // Billing Information
                disable_date: {
                    required: true,
                },
                parent_id: {
                    required: true,

                }
            },

            //display error alert on form submit
            invalidHandler: function (event, validator) {
                // swal.fire({
                //     "title": "",
                //     "text": "There are some errors in your submission. Please correct them.",
                //     "type": "error",
                //     "confirmButtonClass": "btn btn-secondary",
                //     "onClose": function(e) {
                //         console.log('on close event fired!');
                //     }
                // });

                event.preventDefault();
            },

            submitHandler: function (form) {
                //form[0].submit(); // submit the form
                swal.fire({
                    "title": "",
                    "text": "Form validation passed. All good!",
                    "type": "success",
                    "confirmButtonClass": "btn btn-secondary"
                });

                return false;
            }
        });
    };

    let initSubmit = function () {
        let datatable = $('.kt-datatable').KTDatatable();

        let btn = active_form.find('[data-ktwizard-type="action-submit"]');
        btn.on('click', function (e) {
            e.preventDefault();
            if (validator_active.form()) {
                // See: src\js\framework\base\app.js
                KTApp.progress(btn);
                KTApp.block(active_form);
                // See: http://malsup.com/jquery/form/#ajaxSubmit
                active_form.ajaxSubmit({

                    success: function () {
                        datatable.reload();
                        setTimeout(function() {
                            KTApp.unprogress(btn);
                            KTApp.unblock(active_form);
                            $('#active').modal('hide');
                        }, 600);

                    }, error: function (data) {
                        KTApp.unprogress(btn);
                        KTApp.unblock(active_form);
                        $.each(data.responseJSON, function (i, item) {
                            toastr.error(data.responseJSON[i][0]);
                        })
                    }
                });
            }
        });
    };
    let initEditSubmit = function () {
        let datatable = $('.kt-datatable').KTDatatable();
        let btn = inactive_form.find('[data-ktwizard-type="action-submit"]');
        btn.on('click', function (e) {
            e.preventDefault();
            if (validator_inactive.form()) {
                KTApp.progress(btn);
                KTApp.block(inactive_form);
                inactive_form.ajaxSubmit({
                    success: function () {
                        datatable.reload();
                        setTimeout(function() {
                            KTApp.unprogress(btn);
                            KTApp.unblock(inactive_form);
                            $('#inactive').modal('hide');
                        }, 600);

                    },
                    error: function (data) {
                        KTApp.unprogress(btn);
                        KTApp.unblock(inactive_form);
                        $.each(data.responseJSON, function (i, item) {
                            toastr.error(data.responseJSON[i][0]);
                        })
                    }
                });
            }
        });
    };


    return {
        // public functions
        init: function () {
            active_form = $('#kt_active_form');
            inactive_form = $('#kt_inactive_form');
            status_active();
            status_inactive();
            initSubmit();
            initEditSubmit();
        }
    };
}();

function action_status(id) {
    $.ajax({
        url: `/hr/employee/status`,
        type: `post`,
        data: {'id': id},
        dataType: 'json',
        success: function (data) {
            if (data.disabled == 1) {
                $('#active').modal('show');
                $('#active_id').val(id);
            } else {
                $('#inactive_id').val(id);
                $("input[name=disable_date]").val(null);
                $('#inactive').modal('show');
                if (data.count != 0) {
                    $('.alert').addClass('show');
                    $('#count').html(data.count);
                    $('#div-superior').removeAttr('hidden', false);
                } else {
                    $('.alert').removeClass('show');
                    $('#div-superior').attr('hidden', true);
                }
            }


        },
        error: function (data) {

        }
    });
}

jQuery(document).ready(function () {
    KTFormControls.init();
});
