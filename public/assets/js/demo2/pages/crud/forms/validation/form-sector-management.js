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
                // Billing Information
                sector_id: {
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

    let edit = function () {
        validator_edit = edit_form.validate({
            // define validation rules
            rules: {

                sector_id: {
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

    $('#add_sector_id').on('change', function () {
        validator_edit.element($('#add_parent_id')); // validate element
    });
    $('#edit_sector_id').on('change', function () {
        validator_add.element($('#edit_department_id')); // validate element
    });
    let initSubmit = function () {
        let btn = add_form.find('[data-ktwizard-type="action-submit"]');
        btn.on('click', function (e) {
            e.preventDefault();
            if (validator_add.form()) {
                // See: src\js\framework\base\app.js
                KTApp.progress(btn);
                KTApp.block(add_form);
                add_form.ajaxSubmit({
                    success: function (data) {
                        KTApp.unprogress(btn);
                        KTApp.unblock(add_form);
                        // form_input([], 'add');
                        $('#add').modal('hide');
                        $('#new_html_sector_department').append(html_sector(data));
                    }, error: function (data) {
                        KTApp.unprogress(btn);
                        KTApp.unblock(add_form);
                        toastr.error(data.responseJSON.message);
                    }
                });
            }
        });
    };
    // let initEditSubmit = function () {
    //     let btn = edit_form.find('[data-ktwizard-type="action-submit"]');
    //     btn.on('click', function (e) {
    //         e.preventDefault();
    //         if (validator_edit.form()) {
    //             KTApp.progress(btn);
    //             KTApp.block(edit_form);
    //             edit_form.ajaxSubmit({
    //                 success: function (data) {
    //                     KTApp.unprogress(btn);
    //                     KTApp.unblock(edit_form);
    //                     let row = $(`.row_${data.data.id}`);
    //                     row.html('');
    //                     row.append(html_sector(data, 'edit'));
    //                     // html_department()
    //                     $('#edit').modal('hide');
    //                 },
    //                 error: function (data) {
    //                     KTApp.unprogress(btn);
    //                     KTApp.unblock(edit_form);
    //                     toastr.error(data.responseJSON.error);
    //                 }
    //             });
    //         }
    //     });
    // };


    return {
        // public functions
        init: function () {
            add_form = $('#kt_add_form');
            edit_form = $('#kt_edit_form');
            add();
            edit();
            initSubmit();
            // initEditSubmit();
        }
    };
}();

// function action_edit(id) {
//     $.ajax({
//         url: `/hr/control-panel/mission/management/department/${id}`,
//         dataType: 'json',
//         success: function (data) {
//             form_input(data, 'edit');
//             $('#edit').modal('show');
//         },
//         error: function (data) {
//
//         }
//     });
// }

function action_delete(id) {
    swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, timer!',
        reverseButtons: true
    }).then(function (result) {
        if (result.value) {
            $.ajax({
                url: `/hr/control-panel/mission/management/department/sector/${id}`,
                type: 'POST',
                data: {_method: 'delete'},
                dataType: 'json',
                success: function (data) {
                    $(`.row_${id}`).remove();
                    swal.fire(
                        'Deleted!',
                        `${data['deleted']}`,
                        'success'
                    )

                },
                error: function (data) {
                    swal.fire(
                        'Cancelled!',
                        data.responseJSON['delete']['0'],
                        'error'
                    );

                }
            });
        } else if (result.dismiss === 'cancel') {
            swal.fire(
                'Cancelled!',
                'Your item is safe :)',
                'error'
            )
        }
    });
}


function html_sector(data) {

    return `<div class="form-group row row_${data.data.id}">
            <div class="col-md-6">
            <label class="review">Department</label>
            <br>
           ${data.data.department_name_en}
    </div>
        <div class="col-md-5">
            <label class="review">Sector</label>
            <br>
               ${data.data.sector_name_en}
    </div>

        <div class="col-md-1">
            <button onclick="action_delete(${data.data.id})" data-form-type="action-edit"  class="btn btn-sm btn-clean btn-icon btn-icon-md test" title="Delete details">
            <i class="la la-trash"></i>
            </button>
        
            </button>
            </div>
            </div>`;


}

jQuery(document).ready(function () {
    KTFormControls.init();
});
