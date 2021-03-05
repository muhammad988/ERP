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
    // $('#mission').on('change', function(){
    //     validator.element($('#mission')); // validate element
    // });
	//
    // $('#department').on('change', function(){
    //     validator.element($('#department')); // validate element
    // }); $('#sector').on('change', function(){
    //     validator.element($('#sector')); // validate element
    // });
    // $('#organisation_unit').on('change', function(){
    //     validator.element($('#organisation_unit')); // validate element
    // });
	let initValidation = function() {
        $.validator.addMethod("mytst", function (value, element) {
            let flag = true;
            $("input.m-input").each(function (i, j) {
                $(this).parent('div.form-group').find('div.error-m').remove();
                $(this).addClass('is-valid-m');
                $(this).parent('div.form-group').removeClass('is-invalid');
                let name=$.trim($(this).attr("name"));
                if ($.trim($(this).val()) == '') {
                    flag = false;
                    $(this).parent('div.form-group').addClass('is-invalid validate');
                    $(this).addClass('is-invalid');
                    $(this).removeClass('is-valid-m');
                    $.trim($(this).attr("aria-describedby",`${name}-${i}-error`));
                    $(this).parent('div.form-group').append(`<div id='${name}-${i}-error'   class="error-m invalid-feedback-m">This field is required.</div>`);
                }
            });


            return flag;


        }, "");
		validator = formEl.validate({
			// Validate only visible fields
			ignore: ":hidden",
			// Validation rules
			rules: {
                'project[name_en]': {
					required: true
				},
                'project[sector_id]': {
                    required: true
                },
                'project[start_date]': {
					required: true
				},
                'project[end_date]': {
					required: true
				},
                'project[organisation_unit_id]': {
					required: true
				},
                'beneficiary[men][]': {
                    mytst: true
				},
                'beneficiary[women][]': {
                    mytst: true
				},
                'beneficiary[boys][]': {
                    mytst: true
				},
                'beneficiary[girls][]': {
                    mytst: true
				},
                'proposal[indirect_beneficiaries]': {
                    required: true
				},
                'proposal[catchment_area]': {
                    required: true
				},
                'proposal[project_summary]': {
                    required: true
				},
               'proposal[overall_objective]': {
                    required: true
				},
                'proposal[needs_assessment]': {
                    required: true
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
                            toastr.error(data.responseJSON[i][0].replace(".", " "));
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
