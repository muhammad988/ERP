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
                department_id: {
                    required: true,
                }, parent_id: {
                    required: true,
                },
                start_date: {
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
                // Billing Information
                department_id: {
                    required: true,
                }, parent_id: {
                    required: true,
                },
                start_date: {
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
    $('#edit_parent_id').on('change', function () {
        validator_add.element($('#edit_parent_id')); // validate element
    });
    $('#add_parent_id').on('change', function () {
        validator_edit.element($('#add_parent_id')); // validate element
    });
    $('#edit_department_id').on('change', function () {
        validator_add.element($('#edit_department_id')); // validate element
    });
    $('#add_department_id').on('change', function () {
        validator_edit.element($('#add_department_id')); // validate element
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
                    form_input([], 'add');
                    $('#add').modal('hide');
                    $('#new_html_department').append(html_department(data,'add'));
                }, error: function (data) {
                    KTApp.unprogress(btn);
                    KTApp.unblock(add_form);
                    toastr.error(data.responseJSON.message);
                }
            });
            }
        });
    };
    let initEditSubmit = function () {
        let btn = edit_form.find('[data-ktwizard-type="action-submit"]');
        btn.on('click', function (e) {
            e.preventDefault();
            if (validator_edit.form()) {
                KTApp.progress(btn);
                KTApp.block(edit_form);
                edit_form.ajaxSubmit({
                    success: function (data) {
                        KTApp.unprogress(btn);
                        KTApp.unblock(edit_form);
                        let row=$(`.row_${data.data.id}`);
                        row.html('');
                        row.append(html_department(data,'edit'));
                        // html_department()
                        $('#edit').modal('hide');
                    },
                    error: function (data) {
                        KTApp.unprogress(btn);
                        KTApp.unblock(edit_form);
                        toastr.error(data.responseJSON.error);
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
        url: `/hr/control-panel/mission/management/department/${id}`,
        dataType: 'json',
        success: function (data) {
            form_input(data, 'edit');
            $('#edit').modal('show');
        },
        error: function (data) {

        }
    });
}
function action_add_sector(id) {
    form_sector_input([], 'add');
    $('#add_sector').modal('show');
}

function action_delete(id) {
    swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, timer!',
        reverseButtons: true
    }).then(function(result){
        if (result.value) {
            $.ajax({
                url: `/hr/control-panel/mission/management/department/${id}`,
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
function form_sector_input(data, type) {
    if (data === undefined || data.length == 0) {
        $(`#${type}_id`).val(null);
    } else {
        $(`#id`).val(data.data.id);
        $(`#${type}_department_id`).val(data.data.department_id);
        $(`#${type}_start_date`).val(data.data.start_date);
        $(`#${type}_end_date`).val(data.data.end_date);
        $(`#${type}_parent_id`).val(data.data.parent_id);
        if (data.data.status==1) {
            $(`#${type}_status`).attr('checked',true);
        }else{
            $(`#${type}_status`).attr('checked',false);
        }
    }
}
function form_input(data, type) {
    if (data === undefined || data.length == 0) {
        $(`#${type}_start_date`).val(null);
        $(`#${type}_end_date`).val(null);
        $(`#${type}_parent_id`).val(null);
        $(`#${type}_department_id`).val(null);
        $(`#${type}_status`).attr('checked',true);
    } else {
        $(`#id`).val(data.data.id);
        $(`#${type}_department_id`).val(data.data.department_id);
        $(`#${type}_start_date`).val(data.data.start_date);
        $(`#${type}_end_date`).val(data.data.end_date);
        $(`#${type}_parent_id`).val(data.data.parent_id);
        if (data.data.status==1) {
            $(`#${type}_status`).attr('checked',true);
        }else{
            $(`#${type}_status`).attr('checked',false);
        }
    }
}

function html_department(data,type) {
    let checked=null;
    if (data.data.status==1)  {
        checked='checked';
    }
    if (type=='add') {
        return `<div class="form-group row row_${data.data.id}">
            <div class="col-md-3">
            <label class="review">department</label>
            <br>
           ${data.data.department_name_en}
    </div>
        <div class="col-md-3">
            <label class="review">parent</label>
            <br>
               ${data.data.parent_name_en}
    </div>
        <div class="col-md-3">
            <label class="review">start date</label>
        <br>
       ${data.data.start_date}
    </div> 
    <div class="col-md-2">
            <label class="review">Active</label>
        <br>
       <label class="kt-checkbox kt-checkbox--bold kt-checkbox--disabled">
<input type="checkbox" ${checked}   disabled="disabled">
<span></span>
</label>
    </div>
        <div class="col-md-1">
            <button onclick="action_delete(${data.data.id})" data-form-type="action-edit" data-id="180719" data-target="#edit_mission" class="btn btn-sm btn-clean btn-icon btn-icon-md test" title="Edit details">
            <i class="la la-trash"></i>
            </button>
            <button onclick="action_edit(${data.data.id})" data-form-type="action-edit" data-id="180719" data-target="#edit_mission" class="btn btn-sm btn-clean btn-icon btn-icon-md test" title="Edit details">
            <i class="la la-edit"></i>
            </button>
            </div>
            </div>`;
    }
    if (type=='edit') {

        return  `<div class="col-md-3">
            <label class="review">department</label>
            <br>
           ${data.data.department_name_en}
    </div>
        <div class="col-md-3">
            <label class="review">parent</label>
            <br>
               ${data.data.parent_name_en}
    </div>
        <div class="col-md-3">
            <label class="review">start date</label>
        <br>
       ${data.data.start_date}
    </div>
        <div class="col-md-2">
            <label class="review">Active</label>
        <br>
       <label class="kt-checkbox kt-checkbox--bold kt-checkbox--disabled">
<input type="checkbox" ${checked}   disabled="disabled">
<span></span>
</label>
    </div>
        <div class="col-md-1">
            <button onclick="action_delete(${data.data.id})" data-form-type="action-edit" data-id="180719" data-target="#edit_mission" class="btn btn-sm btn-clean btn-icon btn-icon-md test" title="Edit details">
            <i class="la la-trash"></i>
            </button>
            <button onclick="action_edit(${data.data.id})" data-form-type="action-edit" data-id="180719" data-target="#edit_mission" class="btn btn-sm btn-clean btn-icon btn-icon-md test" title="Edit details">
            <i class="la la-edit"></i>
            </button>
            </div>`;
    }


}

jQuery(document).ready(function () {
    KTFormControls.init();
});
