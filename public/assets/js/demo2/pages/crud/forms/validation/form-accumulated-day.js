// Class definition

let KTFormControls = function () {
    let add_form;
    let edit_form;
    let validator_add;
    let validator_edit;

    let add = function () {
        validator_add = add_form.validate({
            // define validation rules
            rules: {
                //= Client Information(step 3)
                // Billing Information
                user_id: {
                    required: true,

                },
                date: {
                    required: true,
                },
                start_time: {
                    required: true,
                },
                end_time: {
                    required: true,
                }

            },

            //display error alert on form submit
            invalidHandler: function (event, validator) {
                // swal.fire({
                //     "title": "",
                //     "text": "There are some errors in your subvisa-type. Please correct them.",
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
    let edit = function () {
        validator_edit = edit_form.validate({
            // define validation rules
            rules: {
                // Billing Information
                user_id: {
                    required: true,

                },
                date: {
                    required: true,
                },
                start_time: {
                    required: true,
                },
                end_time: {
                    required: true,
                }
            },

            //display error alert on form submit
            invalidHandler: function (event, validator) {
                // swal.fire({
                //     "title": "",
                //     "text": "There are some errors in your subvisa-type. Please correct them.",
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
    $('#edit-user-id').on('change', function(){
        validator_add.element($('#edit-user-id')); // validate element
    });
    $('#add-user-id').on('change', function(){
        validator_edit.element($('#add-user-id')); // validate element
    });
    let initSubmit = function () {
        let btn = add_form.find('[data-ktwizard-type="action-submit"]');
        btn.on('click', function (e) {
            e.preventDefault();
            if (validator_add.form()) {
                // See: src\js\framework\base\app.js
                KTApp.progress(btn);
                KTApp.block(add_form);
                // See: http://malsup.com/jquery/form/#ajaxSubmit
                add_form.ajaxSubmit({
                    success: function () {
                        KTApp.unprogress(btn);
                        KTApp.unblock(add_form);
                        let datatable = $('.kt-datatable').KTDatatable();
                        datatable.reload();
                        $('#add').modal('hide');
                        form_input([], 'add');
                    }, error: function (data) {
                        KTApp.unprogress(btn);
                        KTApp.unblock(add_form);
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
        let btn = edit_form.find('[data-ktwizard-type="action-submit"]');
        btn.on('click', function (e) {
            e.preventDefault();
            if (validator_edit.form()) {
                KTApp.progress(btn);
                KTApp.block(edit_form);
                edit_form.ajaxSubmit({
                    success: function () {
                        datatable.reload();
                        KTApp.unprogress(btn);
                        KTApp.unblock(edit_form);
                        $('#edit').modal('hide');
                    },
                    error: function (data) {
                        KTApp.unprogress(btn);
                        KTApp.unblock(edit_form);
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
            add_form = $('#kt_add_form');
            edit_form = $('#kt_edit_form');
            add();
            edit();
            initSubmit();
            initEditSubmit();
        }
    };
}();

function action_edit(id) {
    $.ajax({
        url: `/leave/accumulated-day/${id}/edit`,
        dataType: 'json',
        success: function (data) {
            form_input(data, 'edit')
            $('#edit').modal('show');
        },
        error: function (data) {
            swal.fire(
                'Something is error!',
                'error'
            );
        }
    });
}

function action_delete(id) {

    function_delete(`/leave/accumulated-day/${id}`);

}

function form_input(data, type) {
    if (data === undefined || data.length == 0) {
        $(`#${type}-user-id`).val(null);
        $(`#${type}-year`).val(null);
        $(`#${type}-number-of-days`).val(null);
    } else {
        $(`#${type}-id`).val(data.data.id);
        $(`#${type}-user-id`).val(data.data.user_id);
        $(`#${type}-year`).val(data.data.year);
        $(`#${type}-number-of-days`).val(data.data.number_of_days);
    }
}

jQuery(document).ready(function () {
    KTFormControls.init();
});
