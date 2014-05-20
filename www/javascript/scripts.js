/*
 * Animate Header Image
 * on MouseEnter()
 *
 */
$(function(){
    var img_a = new Image();
    img_a.src ='/images/logo_animated.gif';
    var img_s = new Image();
    img_s.src ='/images/logo_static.png';
    $('.brandLogo').mouseenter(function(){
        if ($('.brandLogo').attr('src') === img_a.src)
            return;

        $(this).attr('src',img_a.src);
        setTimeout(function() {
            $('.brandLogo').attr('src',img_s.src);
        }, 3500);
    });
});