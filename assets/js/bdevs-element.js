(function ($) {

    var WidgetSliderHerowidthElementorHandler = function ($scope, $) {

        var carousel_elem = $scope.find('.bdevs-element').eq(0);

        if (carousel_elem.length > 0) {

            var settings = carousel_elem.data('slider_options');
            carousel_elem.slick(settings);
        }

    };

    // Make sure you run this code under Elementor..
    $(window).on('elementor/frontend/init', function () {

        elementorFrontend.hooks.addAction('frontend/element_ready/bdevs-elementor.default', WidgetSliderHerowidthElementorHandler);

    });




jQuery(window).on('elementor/frontend/init', function(){
        elementorFrontend.hooks.addAction('frontend/element_ready/post_slider.default', function ($scope, $) {
            var elem = $scope.find('.flickfeed');


            elem.slick({
                dots: false,
                infinite: false,
                speed: 600,
                slidesToShow: 6.17,
                slidesToScroll: 3,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3.1,
                            slidesToScroll: 3

                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2.1,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2.1,
                            slidesToScroll: 2,
                            arrows: false
                        }
                    }
                ]
            });
        });
    });

    jQuery(window).on('elementor/frontend/init', function(){
        elementorFrontend.hooks.addAction('frontend/element_ready/post_listslider.default', function ($scope, $) {
            var elem = $scope.find('.flickfeed');
            elem.slick({
                dots: false,
                infinite: false,
                speed: 600,
                slidesToShow: 6.17,
                slidesToScroll: 3,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3.1,
                            slidesToScroll: 3

                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2.1,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2.1,
                            slidesToScroll: 2,
                            arrows: false
                        }
                    }
                ]
            });
        });
    });

})(jQuery);
