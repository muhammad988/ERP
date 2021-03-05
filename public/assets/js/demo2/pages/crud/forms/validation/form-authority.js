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
                role_id: {
                    required: true,
                },
                user_id: {
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
                role_id: {
                    required: true,
                },
                user_id: {
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
                        KTApp.unblock(add_form);
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
        url: `/authority/${id}/edit`,
        dataType: 'json',
        success: function (data) {
            form_input(data, 'edit')
        },
        error: function (data) {

        }
    });
}

function action_delete(id) {

    function_delete(`/authority/${id}`);

}

function form_input(data, type) {
    if (data === undefined || data.length == 0) {
        $(`#${type}_user`).val(null);
        $(`#${type}_project`).val(null);
        $(`#${type}_view`).val(null);
        $(`#${type}_add`).val(null);
        $(`#${type}_update`).val(null);
        $(`#${type}_disable`).val(null);
        $(`#${type}_delete`).val(null);
    } else {
        $(`#${type}_id`).val(data.data.id);
        $(`#${type}_user`).val(data.data.user_id);
        $(`#${type}_project`).val(data.data.project_id);
        $(`#${type}_role`).val(data.data.role_id);
        if (data.data.view==1) {
            $(`#${type}_view`).attr('checked',true);
        }else{
            $(`#${type}_view`).attr('checked',false);
        }
        if (data.data.add==1) {
            $(`#${type}_add`).attr('checked',true);
        }else{
            $(`#${type}_add`).attr('checked',false);
        }
        if (data.data.update==1) {
            $(`#${type}_update`).attr('checked',true);
        }else{
            $(`#${type}_update`).attr('checked',false);
        }
        if (data.data.disable==1) {
            $(`#${type}_disable`).attr('checked',true);
        }else{
            $(`#${type}_disable`).attr('checked',false);
        }
        if (data.data.delete==1) {
            $(`#${type}_delete`).attr('checked',true);
        }else{
            $(`#${type}_delete`).attr('checked',false);
        }
        $('#edit').modal('show');
    }
}

jQuery(document).ready(function () {
    KTFormControls.init();
});
