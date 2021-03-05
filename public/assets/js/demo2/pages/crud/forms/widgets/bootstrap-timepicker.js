// Class definition

var KTBootstrapTimepicker = function () {

    // Private functions
    var demos = function () {
        // minimum setup
        $('.kt_timepicker_1, #kt_timepicker_1_modal').timepicker(
            {
                minuteStep: 1,
                showMeridian: false,
                snapToStep: true

            }
        );

        // minimum setup
        $('.kt_timepicker_2, #kt_timepicker_2_modal').timepicker({
            minuteStep: 1,
            defaultTime: '',
            showMeridian: false,
            snapToStep: true
        });

        // default time
        $('#kt_timepicker_3, #kt_timepicker_3_modal').timepicker({
            defaultTime: '11:45:20 AM',
            minuteStep: 1,
            showSeconds: true,
            showMeridian: true
        });

        // default time
        $('#kt_timepicker_4, #kt_timepicker_4_modal').timepicker({
            defaultTime: '10:30:20 AM',
            minuteStep: 1,
            showSeconds: true,
            showMeridian: true
        });

        // validation state demos
        // minimum setup
        $('#kt_timepicker_1_validate, #kt_timepicker_2_validate, #kt_timepicker_3_validate').timepicker({
            minuteStep: 1,
            showSeconds: true,
            showMeridian: false,
            snapToStep: true
        });
    }
    var modalDemos_timepicker = function() {
        $('#edit').on('shown.bs.modal', function () {
            // basic
            $('.kt_timepicker_2_1_modal').timepicker('remove')
          $('.kt_timepicker_2_1_modal').timepicker({
                minuteStep: 1,
                defaultTime: '',
                showMeridian: false,
                snapToStep: true
            });
        });
    }
    return {
        // public functions
        init: function() {
            demos();
            modalDemos_timepicker();
        }
    };
}();

jQuery(document).ready(function() {
    KTBootstrapTimepicker.init();
});
