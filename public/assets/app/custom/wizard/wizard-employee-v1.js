"use strict";

// Class definition
let KTWizard1 = function () {
	// Base elements
	let wizardEl;
	let formEl;
	let validator;
	let wizard;

	// Private functions
	let initWizard = function () {
		// Initialize form wizard
		wizard = new KTWizard('kt_wizard_v1', {
			startStep: 1
		});

		// Validation before going to next page
		wizard.on('beforeNext', function(wizardObj) {
			if (validator.form() !== true) {
				 // wizardObj.stop();  // don't go to the next step
			}
		});

		// Change event
		wizard.on('change', function(wizard) {
			setTimeout(function() {
				KTUtil.scrollTop();
			}, 500);
		});
	};
    // $('#superior').select2({
    // });
    // select2
    $('#superior').on('change', function(){
        validator.element($('#superior')); // validate element
    });

    $('#position').on('change', function(){
        validator.element($('#position')); // validate element
    });
    $('#department').on('change', function(){
        validator.element($('#department')); // validate element
    });
	let initValidation = function() {
		validator = formEl.validate({
			// Validate only visible fields
			ignore: ":hidden",
			// Validation rules
			rules: {
                employee_number: {
					required: true
				},
                first_name_en: {
					required: true
				},
                last_name_en: {
					required: true
				},
                first_name_ar: {
					required: true
				},
                last_name_ar: {
					required: true
				},
                position_id: {
					required: true
				},
                mission_id: {
					required: true
				},
                department_id: {
					required: true
				},
                number_of_hours: {
					required: true
				},
                contract_type_id: {
					required: true
				},
                basic_salary: {
					required: true
				},
                gross_salary: {
					required: true
				},
                taxes: {
					required: true
				},
                insurance: {
					required: true
				},
                parent_id: {
					required: true
				},
                user_group_id: {
					required: true
				},
                email: {
					required: true,
                    email: true
				},
                password: {
					required: true,
				}
			},

			// Display error
			invalidHandler: function(event, validator) {
				KTUtil.scrollTop();
				swal.fire({
					"title": "",
					"text": "There are some errors in your submission. Please correct them.",
					"type": "error",
				});
			},

			// Submit valid form
			submitHandler: function (form) {
			}
		});
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
						});
						window.location.href = "/";
					},
                    error: function (data) {
                        KTApp.unprogress(btn);
                        KTApp.unblockPage(formEl);
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
		init: function() {
			wizardEl = KTUtil.get('kt_wizard_v1');
			formEl = $('#kt_form');
			initWizard();
			initValidation();
			initSubmit();
		}
	};
}();

jQuery(document).ready(function() {
	KTWizard1.init();
});
