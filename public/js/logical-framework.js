$('#add_outcome').on('click', function () {
        // let outcome_child_count = $('#outcomes').children('.outcome').length;
        $('#outcomes').append('<div class="outcome"></div>')
            .children()
            .last()
            .each(function () {
                $(this).append([
                    '<div class="row  form-group align-items-center">' +
                    '<div class="col-lg-12  outcome-title"> <h5></h5></div>' +
                    '<div class="col-lg-10 outcome-description">' +
                    '<label>Description<span class="required" aria-required="true"> *</span></label>' +
                    '<textarea class="form-control kt_maxlength_3" maxlength="100" required   placeholder="Description"></textarea> ' +
                    '</div>' +
                    '<div class="col-lg-2">' +
                    ' <button type="button"  class="btn btn-label-info btn-sm  add_output"><i class="la la-plus"></i>put</button> ' +
                    ' <button type="button"  class="btn  btn-label-danger btn-sm deleteOutcome float-right"><i class="la la-trash-o"></i></button> ' +
                    '</div>' +
                    '</div>']);
            });
        nameOutcome();
    $('.kt_maxlength_3').maxlength({
        alwaysShow: true,
        threshold: 5,
        warningClass: "kt-badge kt-badge--primary kt-badge--rounded kt-badge--inline",
        limitReachedClass: "kt-badge kt-badge--brand kt-badge--rounded kt-badge--inline"
    });
        return false;
    });
$(document).on('click', '.add_output', function () {
    $(this).parents('.outcome').append('<div class="output"></div>')
        .children('div')
        .last()
        .each(function () {
            $(this).append('<div class="row  form-group   align-items-center">' +
                '<div class="col-lg-12 title"> <h5>' +
                '</h5>' +
                '</div>' +
                '<div class="col-lg-5  form-group  description">  ' +
                '<label>Description<span class="required" aria-required="true"> *</span></label>' +
                '<textarea class="form-control kt_maxlength_3" maxlength="100" required="" placeholder="Description"></textarea>' +
                '</div>' +
                '<div class="col-lg-5  form-group  assumption">' +
                '<label>Assumption Risk<span class="required" aria-required="true"> *</span></label>' +
                '<textarea class="form-control kt_maxlength_3" maxlength="100" required="" placeholder="Assumption Risk"></textarea>' +
                '</div>' +
                '<div class="col-lg-2">' +
                ' <button type="button" class="btn btn-sm btn-label-info add_activity" ><i class="la la-plus"></i>Act</button> ' +
                '<button type="button" class="btn btn-sm btn-label-info addIndicator" ><i class="la la-plus"></i>Ind</button> ' +
                '<button class="btn btn-sm btn-label-danger deleteOutput float-right"><i class="la la-trash-o"></i></button> ' +
                '</div>' +
                '</div>'+
            '<div class="row output-12"' +
            '><div class="col-lg-7 activity-7">' +
            '</div>' +
            '<div class="col-lg-5 indicator-5">' +
            ' </div>' +
            '</div>' );

        });
    $('.kt_maxlength_3').maxlength({
        alwaysShow: true,
        threshold: 5,
        warningClass: "kt-badge kt-badge--primary kt-badge--rounded kt-badge--inline",
        limitReachedClass: "kt-badge kt-badge--brand kt-badge--rounded kt-badge--inline"
    });
     nameOutput();
    return false;
});
$(document).on('click', '.add_activity', function () {
    // activitiesChildCount = $(this).parent('.output').find('.activity');
    // activitiesChildCountLen = activitiesChildCount.length;
    $(this).parents('.output').children('div').children('div .activity-7').append('<div class="activity"></div>')
        .children('div')
        .last()
        .each(function () {
            $(this).append(' <div class="row form-group align-items-center">'+
                '<div class="col-lg-12 title"><h5>Activity</h5></div>' +
                '<div class="col-lg-2 activity_phase  form-group ">' +
                '     <label class="title_phase">Activity Phase<span class="required" aria-required="true"> *</span></label>' +
                '     <select required class=" form-control select_activity_phase"><option value="" selected="selected">Please Select</option><option value="140173">Inception phase</option><option value="140174">Implementation phase</option></select>' +
                ' </div>' +
                '<div class="col-lg-2 responsibility  form-group ">' +
                '<label class="title_responsibility">Responsibility<span class="required" aria-required="true"> *</span> </label><i style="float: right;' +
                '" class="la la-user-plus fa-lg get_employee"></i>' +
                '<select required class="form-control select_responsibility "><option value="" selected="selected">Please Select</option></select>                                                      ' +
                '<input class="option_name_responsibility" type="hidden">' +
                '</div>' +
                ' <div class="col-lg-2 start_date  form-group ">' +
                '     <label class="title_start_date">Start Date<span class="required" aria-required="true"> *</span></label><input required="" class="form-control  date-picker start_date_activity" data-date-format="yyyy-mm-dd" type="text">' +
                ' </div>' +
                ' <div class="col-lg-2 end_date  form-group ">' +
                '     <label class="title_end_date">End Date<span class="required" aria-required="true"> *</span></label><input required="" class="form-control  date-picker end_date_activity" data-date-format="yyyy-mm-dd" type="text" >' +
                ' </div>' +
                '<div class="col-lg-2 cost  form-group ">' +
                '     <label class="title_cost">cost <span class="required" aria-required="true"> *</span></label>' +
                '     <input required class="form-control money">' +
                ' </div>' +
                ' <div class="col-lg-9  form-group  description_activity">' +
                '   <label class="title_description">Description<span class="required" aria-required="true"> *</span></label>' +
                '<textarea class="form-control textarea_description_activity kt_maxlength_3" maxlength="100" required="" placeholder="Description"></textarea>' +
                ' </div>' +
                ' <div class="col-lg-3">' +
                '<button class="btn btn-label-danger btn-sm deleteActivity"><i class="la la-trash-o"></i></button>' +
                ' </div> ' +
                '</div>');
            $('.date-picker').datepicker({});
            $(".money").inputmask({
                "alias": "decimal",
                "digits": 2,
                "autoGroup": true,
                "allowMinus": true,
                "rightAlign": false,
                "groupSeparator": ",",
                "radixPoint": ".",
                autoUnmask: true,
            });
            $('.kt_maxlength_3').maxlength({
                alwaysShow: true,
                threshold: 5,
                warningClass: "kt-badge kt-badge--primary kt-badge--rounded kt-badge--inline",
                limitReachedClass: "kt-badge kt-badge--brand kt-badge--rounded kt-badge--inline"
            });
        });
    nameActivity();
    return false;
});
$(document).on('click', '.addIndicator', function () {
    // indicatorsChildCount = $(this).parent('.output').find('.indicator');
    // indicatorsChildCountLen = indicatorsChildCount.length;
    $(this).parents('.output').children('div').children('div .indicator-5').append('<div class="indicator"></div>')
        .children('div')
        .last()
        .each(function () {
            $(this).append('<div class="row  form-group   align-items-center">'+
                '<div class="col-lg-12 title"> <h5 >Indicator'+
                '</h5>'+
                '</div>'+
                '<div class="col-lg-5  form-group  indicator_description">'+
                '<label>Description</label>'+
                '<textarea class="form-control kt_maxlength_3" maxlength="100" required placeholder="Description"></textarea>'+
                '</div>' +
                '<div class="col-lg-5  form-group  verification">'+
                '<label>Verification</label>'+
                '<textarea class="form-control kt_maxlength_3" maxlength="100" required placeholder="verification"></textarea>'+
                '</div>'+
                '<div class="col-lg-2">'+
                '<button class="btn btn-label-danger btn-sm deleteIndicator float-right"><i class="la la-trash-o"></i></button>'+
                '</div>'+
                '</div>');
        });
    $('.kt_maxlength_3').maxlength({
        alwaysShow: true,
        threshold: 5,
        warningClass: "kt-badge kt-badge--primary kt-badge--rounded kt-badge--inline",
        limitReachedClass: "kt-badge kt-badge--brand kt-badge--rounded kt-badge--inline"
    });
    nameIndicator();
    return false;
});
$(document).on('click', '.deleteOutcome', function () {
    $(this).parents('div .outcome').remove();
    nameOutcome();
    nameOutput();
    nameActivity();
    nameIndicator();
});
$(document).on('click', '.deleteOutput', function () {
    $(this).parents('div .output' ).remove();
    nameOutput();
    nameActivity();
    nameIndicator();
});
$(document).on('click', '.deleteActivity', function () {
    $(this).parents('div .activity').remove();
    nameActivity();
});
$(document).on('click', '.get_employee', function () {
        $('#employee_responsibility').val($(this).parents('.activity').attr('id'));
    $('#add').modal('show');
});
$(document).on('click', '.deleteIndicator', function () {
    $(this).parents('div .indicator').remove();
    nameIndicator();
});


function nameOutcome() {
    $('#outcomes').children('.outcome').each(function (outcomeCounter) {
        outcomeCounter += 1;
        $(this).attr('id', 'outcome' + outcomeCounter);
        $(this).attr('name', 'outcome' + outcomeCounter);
        // $('.outcome').children('.add_output').each(function (outcomeCounter) {
        //     outcomeCounter = outcomeCounter + 1;
        //     $(this).attr('id', 'outcome' + outcomeCounter);
        //     $(this).html('add Output');
        // });
        $('.outcome div').children('div .outcome-description').children('textarea').each(function (outcomeCounter) {

            outcomeCounter = outcomeCounter + 1;
            $(this).attr('id', 'outcome' + outcomeCounter);
            $(this).attr('name', 'description[]');
            $(this).attr('placeholder', 'Description ' + outcomeCounter);
            $(this).attr("required", "true");
        });
        $('.outcome div').children('div .outcome-title').children('h5').each(function (outcomeCounter) {
            outcomeCounter = outcomeCounter + 1;
            $(this).html('Outcome - ' + outcomeCounter);
        });
    });
    return false;
}
let nameOutput = function () {
    $('#outcomes').children('.outcome').children('.output').each(function () {
        parentId = $(this).parent('div div').attr('id');
        parentIdLen = parentId.length;
        parentIdSubStr = parentId.substring(parentIdLen - 1, parentIdLen);
        parentIdSubStrInt = parseInt(parentIdSubStr);
        $(this).parent('.outcome').children('div .output').each(function (output_counter) {
            output_counter += 1;
            $(this).attr('id', 'output' + parentIdSubStrInt + output_counter);
            $(this).children('div').children('div .description').children('textarea').each(function () {
                $(this).attr('id', 'output_description' + parentIdSubStrInt + output_counter);
                $(this).attr('name', 'output_description_' + parentIdSubStrInt + '[]');
                $(this).attr('placeholder', 'Description ' + parentIdSubStrInt +' '+ output_counter);
                $(this).attr("required", "true");

            });
            $(this).children('div').children('div .assumption').children('textarea').each(function () {
                $(this).attr('id', 'output_assumption' + parentIdSubStrInt + output_counter);
                $(this).attr('name', 'output_assumption_' + parentIdSubStrInt + '[]');
                $(this).attr('placeholder', 'Risk & Assumption ' + parentIdSubStrInt  +' '+ output_counter);
                $(this).attr("required", "true");
            });
            $(this).children('div').children('div .title').children('h5').each(function () {
                $(this).html('Output-' + parentIdSubStrInt  +' '+ output_counter);
            });
        });
    });
    return false;
};
let nameActivity = function () {
    $('#outcomes').children('.outcome').children('.output').children('div').children('div .activity-7').children('.activity').each(function () {
        parentActivityId = $(this).parents('div .output').attr('id');
        parentActivityIdLen = parentActivityId.length;
        parentActivityIdSubStr = parentActivityId.substring(parentActivityIdLen - 2, parentActivityIdLen);
        parentActivityIdSubStrInt = parseInt(parentActivityIdSubStr);
        $(this).parents('.output').children('div .output-12').children('div .activity-7').children('div .activity').each(function (activityCounter) {
            activityCounter += 1;
            $(this).attr('id', 'activity' + parentActivityIdSubStr + activityCounter);
            $(this).attr('name', 'activity' + parentActivityIdSubStr + activityCounter);

            $(this).children('div').children('div .title').children('h5').each(function () {
                $(this).html('Activity-' + parentActivityIdSubStr+activityCounter);
            });
            $(this).children('div').children('div .description_activity').children('textarea').each(function () {
                $(this).attr('id', 'activity_description_' + parentActivityIdSubStr + activityCounter);
                $(this).attr('name', 'activity_description_' + parentActivityIdSubStr  + '[]');
                $(this).attr('placeholder', 'Activity Description-' + parentActivityIdSubStr + activityCounter);
                $(this).attr("required", "true");
            });
            $(this).children('div').children('div .start_date').children('input').each(function () {
                $(this).attr('id', 'start_date_' + parentActivityIdSubStr + activityCounter);
                $(this).attr('name', 'start_date_' + parentActivityIdSubStr + '[]');
                $(this).attr("required", "true");
            });
            $(this).children('div').children('div .end_date').children('input').each(function () {
                $(this).attr('id', 'end_date_' + parentActivityIdSubStr + activityCounter);
                $(this).attr('name', 'end_date_' + parentActivityIdSubStr   +'[]');
                $(this).attr("required", "true");
            });
            $(this).children('div').children('.activity_phase').children('select').each(function () {
                $(this).attr('id', 'activity_phase_' + parentActivityIdSubStr + activityCounter);
                $(this).attr('name', 'activity_phase_' + parentActivityIdSubStr   +'[]');
            });
            $(this).children('div').children('.responsibility').children('select').each(function () {
                $(this).attr('id', 'responsibility_' + parentActivityIdSubStr + activityCounter);
                $(this).attr('name', 'responsibility_' + parentActivityIdSubStr + '[]');
            });
            $(this).children('div').children('.responsibility').children('input').each(function () {
                $(this).attr('id', 'option_name_responsibility_' + parentActivityIdSubStr + activityCounter);
                $(this).attr('name', 'option_name_responsibility_' + parentActivityIdSubStr + '[]');
            });
            $(this).children('div').children('.cost').children('input').each(function () {
                $(this).attr('id', 'cost_' + parentActivityIdSubStr + activityCounter);
                $(this).attr('name', 'cost_' + parentActivityIdSubStr +  '[]');
            });
            $(this).children('h4').each(function () {
                $(this).html('Activity-' + parentActivityIdSubStr + activityCounter);
            });
        });
    });
    return false;
};
let nameIndicator = function () {
    $('#outcomes').children('.outcome').children('.output').children('div').children('div .indicator-5').children('.indicator').each(function () {
        parentIndicatorId = $(this).parents('div .output').attr('id');
        parentIndicatorIdLen = parentIndicatorId.length;
        parentIndicatorIdSubStr = parentIndicatorId.substring(parentIndicatorIdLen - 2, parentIndicatorIdLen);
        parentIndicatorIdSubStrInt = parseInt(parentIndicatorIdSubStr);
        $(this).parents('.output').children('div .output-12').children('div .indicator-5').children('div .indicator').each(function (indicatorCounter) {
                indicatorCounter += 1;
                $(this).attr('id', 'indicator' + parentIndicatorIdSubStrInt + indicatorCounter);
                $(this).attr('name', 'indicator' + parentIndicatorIdSubStrInt + indicatorCounter);
                $(this).children('div').children('div .indicator_description').children('textarea').each(function () {
                    $(this).attr('id', 'indicator_description' + parentIndicatorIdSubStrInt + indicatorCounter);
                    $(this).attr('name', 'indicator_description_' + parentIndicatorIdSubStrInt + '[]');
                    $(this).attr('placeholder', 'Description-' + parentIndicatorIdSubStrInt + indicatorCounter);
                    $(this).attr("required", "true");
                });
                $(this).children('div').children('div .verification').children('textarea').each(function () {
                    $(this).attr('id', 'verification' + parentIndicatorIdSubStrInt + indicatorCounter);
                    $(this).attr('name', 'verification_' + parentIndicatorIdSubStrInt + '[]');
                    $(this).attr('placeholder', 'verification-' + parentIndicatorIdSubStrInt + indicatorCounter);
                    $(this).attr("required", "true");
                });
                $(this).children('div').children('div .title').children('h5').each(function () {
                    $(this).html('Indicator-' + parentIndicatorIdSubStrInt + indicatorCounter);
                });
            });
    });
    return false;
};
