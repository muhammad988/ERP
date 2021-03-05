// Class definition

let KTFormControls = function () {
    // Private functions
    let validator ;
    let formEl ;
    let demo = function () {
        validator  =  $( "#kt_form_2" ).validate({
            // define validation rules
            ignore: ":hidden",
            rules: {
                // Billing Information
                // receipt_file: {
                //     required: true
                // },
            },

            //display error alert on form submit
            invalidHandler: function(event, validator) {
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

        $('.applyBtn').click( function(){

            // $('#date_range').val(1);
            setTimeout(function() {validator.element($('#date_range')) }, 50);
            // validate element
            // $('#date_range').val(null);
        });
        // $(document).on('change', `#date_range`, function () {
        //     alert('test 1');
        //     validator.element($(this)); // validate element
        // });
    };
    let initSubmit = function() {
        let btn = formEl.find('[data-ktwizard-type="action-submit"]');

        btn.on('click', function(e) {
            e.preventDefault();
            if (validator.form()) {
                KTApp.progress(btn);
                KTApp.blockPage(formEl);
                formEl.ajaxSubmit({
                    success: function() {
                        KTApp.unprogress(btn);
                        KTApp.unblockPage(formEl);
                        swal.fire({
                            "title": "",
                            "text": "The application has been successfully submitted!",
                            "type": "success",
                            showConfirmButton: false,
                        });
                        window.location.href = "/";
                    },
                    error: function (data) {
                        KTApp.unprogress(btn);
                        KTApp.unblockPage(formEl);
                        $.each(data.responseJSON, function (i, item) {
                            toastr.error(data.responseJSON[i][0].replace(".", " "));
                        })
                    }
                });
            }else{
                $.each(validator.errorMap, function (index, value) {

                    toastr.error(index.replace(/_/g, ' ').replace('id', ' ')+' '+ value);
                });
            }
        });
    };
    return {
        // public functions
        init: function() {
            formEl =  $( "#kt_form_2");

            demo();
            initSubmit();

        }
    };
}();

jQuery(document).ready(function() {
    KTFormControls.init();
});
