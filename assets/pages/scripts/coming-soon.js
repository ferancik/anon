var ComingSoon = function () {


    return {
        //main function to initiate the module
        init: function () {
            $('.coming-soon-countdown').each(function (i, obj) {
                var counDownTime = $(this).children('input').val();
                var coundDownId = $(this).children('.countDownElement').attr("id");
                
                var austDay = new Date(counDownTime*1000);
//                austDay = new Date(austDay.getFullYear() + 1, 1 - 1, 26);
                $('#'+coundDownId).countdown(
                        {
                            until: austDay,
                        }
                );
            });

        }

    };

}();

jQuery(document).ready(function () {
    ComingSoon.init();
});