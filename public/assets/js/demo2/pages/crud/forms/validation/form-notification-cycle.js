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
                name_en: {
                    required: true,
                    minlength: 3,
                    maxlength: 30
                },
                name_ar: {
                    required: true,
                    minlength: 3,
                    maxlength: 30
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
                name_en: {
                    required: true,
                    minlength: 3,
                    maxlength: 30
                },
                name_ar: {
                    required: true,
                    minlength: 3,
                    maxlength: 30
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
                        form_input([], 'add')

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
        url: `/hr/control-panel/notification-cycle/${id}/edit`,
        dataType: 'json',
        success: function (data) {
            form_input(data, 'edit')
        },
        error: function (data) {

        }
    });
}

function action_delete(id) {

    function_delete(`/hr/control-panel/notification-cycle/${id}`);

}

function form_input(data, type) {
    if (data === undefined || data.length == 0) {
        $(`#${type}_name_en`).val(null);
        $(`#${type}_name_ar`).val(null);
        $(`#${type}_notification_receiver`).val(null);
        $(`#${type}_notification_type`).val(null);
        $(`#${type}_number_of_superiors`).val(null);
        $(`#${type}_group_number`).val(null);
        $(`#${type}_authorized`).prop('checked',false);
    } else {
        $(`#${type}_id`).val(data.data.id);
        $(`#${type}_name_en`).val(data.data.name_en);
        $(`#${type}_name_ar`).val(data.data.name_ar);
        $(`#${type}_notification_receiver`).val(data.data.notification_receiver_id);
        $(`#${type}_notification_type`).val(data.data.notification_type_id);
        $(`#${type}_number_of_superiors`).val(data.data.number_of_superiors);
        $(`#${type}_group_number`).val(data.data.group_number);
        $(`#${type}_authorized`).prop('checked',data.data.authorized);
    }
}

jQuery(document).ready(function () {
    KTFormControls.init();
});
