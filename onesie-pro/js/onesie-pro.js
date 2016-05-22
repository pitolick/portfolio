jQuery(document).ready(function($){

    // add mobile class for css targeting
    if ($(window).width() < 600) {
        $('body').addClass('mobile');
    } else {
        $('body').removeClass('mobile');
    }

    $(window).bind('scroll', function() {
         if ($(window).scrollTop() > 150) {
             $('.site-title').addClass('fixed');
             $('.main-navigation').addClass('scrolling');
         }
         else {
             $('.site-title').removeClass('fixed');
             $('.main-navigation').removeClass('scrolling');
         }
    });

    // set height of blocks based on window height
    var win_height = $(window).height() - 100;

    if ( ! win_height )
        return;

    // Sharre widget
    $('#twitter').sharrre({
            share: {
                twitter: true
            },
            template: '<a class="share" href="#"><div class="genericon genericon-twitter"></div></a>',
            enableHover: false,
            click: function(api, options){
                api.simulateClick();
                api.openPopup('twitter');
            }
        });

        $('#facebook').sharrre({
            share: {
                facebook: true
            },
            template: '<a class="share" href="#"><div class="genericon genericon-facebook"></div></a>',
            enableHover: false,
            click: function(api, options){
                api.simulateClick();
                api.openPopup('facebook');
            }
        });

    // create anchor links
    $('a[href*=#]:not([href=#])').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
            if (target.length) {
                $('html,body').animate({
                    scrollTop: target.offset().top
                }, 300);
                return false;
            }
        }
    });

    // magnific portfolio popup
    $('.gallery-item').magnificPopup({
        type: 'image'/*,
        gallery:{
            enabled:true
        }*/
    });

    // magnific sell media popup
    $('.gallery-sm-item').magnificPopup({
        type: 'image',
        gallery:{
            enabled:true
        }
    });

    // magnific blog popup
    $('.gallery-blog-item').magnificPopup({
        type: 'image',
        gallery:{
            enabled:true
        }
    });

});

jQuery(window).load(function(){
    $c = 1;
    jQuery(".flexslider").each(function(){

        // Add unique control nav class
        jQuery(this).flexslider({
            controlNav: true,
            directionNav: false,
            slideshow: false,
            prevText: "",
            nextText: "",
            smoothHeight: true,
        });
        $c++;
    });
});