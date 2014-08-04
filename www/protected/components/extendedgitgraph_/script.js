jQuery(document).ready(function ($) {
    $('.svg-tip').fadeOut(0);
    $('.svg-tip').css({opacity: 1});

    $("rect").mouseenter(
        function (event) {
            $('.svg-tip').stop(true, true);

            $('.svg-tip').fadeIn(400);

            $('.svg-tip strong').html($(event.target).attr('hvr_header'));
            $('.svg-tip span').html($(event.target).attr('hvr_content'));

            $('.svg-tip').css({left: $(event.target).position().left  - $('.svg-tip').outerWidth() /2 - 2.5 + 9});
            $('.svg-tip').css({top:  $(event.target).position().top   - $('.svg-tip').outerHeight()   - 10});

        }
    );
    $("rect").mouseleave(
        function () {
            $('.svg-tip').stop(true, true);
            $('.svg-tip').fadeOut(400);
        }
    );
});