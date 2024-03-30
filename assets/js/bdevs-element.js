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
                slidesToShow: 4.5,
                slidesToScroll: 3,
                prevArrow: "<button type='button' class='slick-prev'><svg width=\"46\" height=\"45\" viewBox=\"0 0 46 45\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\n" +
                    "<path fill-rule=\"evenodd\" clip-rule=\"evenodd\" d=\"M22.6492 1C6.41367 1 1.00027 6.37616 1.00027 22.5C1.00027 38.6238 6.41367 44 22.6492 44C38.8847 44 44.2981 38.6238 44.2981 22.5C44.2981 6.37616 38.8847 1 22.6492 1Z\" stroke=\"#6C6C8B\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>\n" +
                    "<path d=\"M26.0239 14.4306C26.0239 14.4306 17.8652 19.9904 17.8652 22.5007C17.8652 25.0109 26.0239 30.5661 26.0239 30.5661\" stroke=\"#6C6C8B\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>\n" +
                    "</svg>\n</button>",
                nextArrow: "<button type='button' class='slick-next'><svg width=\"46\" height=\"45\" viewBox=\"0 0 46 45\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\n" +
                    "<path fill-rule=\"evenodd\" clip-rule=\"evenodd\" d=\"M23.3511 1C39.5866 1 45 6.37616 45 22.5C45 38.6238 39.5866 44 23.3511 44C7.11555 44 1.70215 38.6238 1.70215 22.5C1.70215 6.37616 7.11555 1 23.3511 1Z\" stroke=\"#4C4C67\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>\n" +
                    "<path d=\"M19.9763 14.4306C19.9763 14.4306 28.135 19.9904 28.135 22.5007C28.135 25.0109 19.9763 30.5661 19.9763 30.5661\" stroke=\"#4C4C67\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>\n" +
                    "</svg>\n</button>",
                responsive: [
                    {
                        breakpoint: 1399,
                        settings: {
                            slidesToShow: 3.5,
                            slidesToScroll: 3

                        }
                    },
                    {
                        breakpoint: 991,
                        settings: {
                            slidesToShow: 2.5,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
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
                slidesToShow: 4.5,
                slidesToScroll: 3,
                prevArrow: "<button type='button' class='slick-prev'><svg width=\"46\" height=\"45\" viewBox=\"0 0 46 45\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\n" +
                    "<path fill-rule=\"evenodd\" clip-rule=\"evenodd\" d=\"M22.6492 1C6.41367 1 1.00027 6.37616 1.00027 22.5C1.00027 38.6238 6.41367 44 22.6492 44C38.8847 44 44.2981 38.6238 44.2981 22.5C44.2981 6.37616 38.8847 1 22.6492 1Z\" stroke=\"#6C6C8B\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>\n" +
                    "<path d=\"M26.0239 14.4306C26.0239 14.4306 17.8652 19.9904 17.8652 22.5007C17.8652 25.0109 26.0239 30.5661 26.0239 30.5661\" stroke=\"#6C6C8B\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>\n" +
                    "</svg>\n</button>",
                nextArrow: "<button type='button' class='slick-next'><svg width=\"46\" height=\"45\" viewBox=\"0 0 46 45\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\n" +
                    "<path fill-rule=\"evenodd\" clip-rule=\"evenodd\" d=\"M23.3511 1C39.5866 1 45 6.37616 45 22.5C45 38.6238 39.5866 44 23.3511 44C7.11555 44 1.70215 38.6238 1.70215 22.5C1.70215 6.37616 7.11555 1 23.3511 1Z\" stroke=\"#4C4C67\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>\n" +
                    "<path d=\"M19.9763 14.4306C19.9763 14.4306 28.135 19.9904 28.135 22.5007C28.135 25.0109 19.9763 30.5661 19.9763 30.5661\" stroke=\"#4C4C67\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>\n" +
                    "</svg>\n</button>",
                responsive: [
                    {
                        breakpoint: 1399,
                        settings: {
                            slidesToShow: 3.5,
                            slidesToScroll: 3

                        }
                    },
                    {
                        breakpoint: 991,
                        settings: {
                            slidesToShow: 2.5,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2,
                            arrows: false
                        }
                    }
                ]
            });
        });
    });



    jQuery(window).on('elementor/frontend/init', function(){
        elementorFrontend.hooks.addAction('frontend/element_ready/related_post_slider.default', function ($scope, $) {
            var elem = $scope.find('.flickfeed');
            elem.slick({
                dots: false,
                infinite: false,
                speed: 600,
                slidesToShow: 4.5,
                slidesToScroll: 3,
                prevArrow: "<button type='button' class='slick-prev'><svg width=\"46\" height=\"45\" viewBox=\"0 0 46 45\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\n" +
                    "<path fill-rule=\"evenodd\" clip-rule=\"evenodd\" d=\"M22.6492 1C6.41367 1 1.00027 6.37616 1.00027 22.5C1.00027 38.6238 6.41367 44 22.6492 44C38.8847 44 44.2981 38.6238 44.2981 22.5C44.2981 6.37616 38.8847 1 22.6492 1Z\" stroke=\"#6C6C8B\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>\n" +
                    "<path d=\"M26.0239 14.4306C26.0239 14.4306 17.8652 19.9904 17.8652 22.5007C17.8652 25.0109 26.0239 30.5661 26.0239 30.5661\" stroke=\"#6C6C8B\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>\n" +
                    "</svg>\n</button>",
                nextArrow: "<button type='button' class='slick-next'><svg width=\"46\" height=\"45\" viewBox=\"0 0 46 45\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\n" +
                    "<path fill-rule=\"evenodd\" clip-rule=\"evenodd\" d=\"M23.3511 1C39.5866 1 45 6.37616 45 22.5C45 38.6238 39.5866 44 23.3511 44C7.11555 44 1.70215 38.6238 1.70215 22.5C1.70215 6.37616 7.11555 1 23.3511 1Z\" stroke=\"#4C4C67\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>\n" +
                    "<path d=\"M19.9763 14.4306C19.9763 14.4306 28.135 19.9904 28.135 22.5007C28.135 25.0109 19.9763 30.5661 19.9763 30.5661\" stroke=\"#4C4C67\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>\n" +
                    "</svg>\n</button>",
                responsive: [
                    {
                        breakpoint: 1399,
                        settings: {
                            slidesToShow: 3.5,
                            slidesToScroll: 3

                        }
                    },
                    {
                        breakpoint: 991,
                        settings: {
                            slidesToShow: 2.5,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2,
                            arrows: false
                        }
                    }
                ]
            });
        });
    });


    jQuery(window).on('elementor/frontend/init', function(){
        elementorFrontend.hooks.addAction('frontend/element_ready/testimonial_ev.default', function ($scope, $) {
            var elem = $scope.find('.flickfeed');
            elem.slick({
                dots: false,
                infinite: false,
                speed: 600,
                slidesToShow: 4.5,
                slidesToScroll: 3,
                prevArrow: "<button type='button' class='slick-prev'><svg width=\"46\" height=\"45\" viewBox=\"0 0 46 45\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\n" +
                    "<path fill-rule=\"evenodd\" clip-rule=\"evenodd\" d=\"M22.6492 1C6.41367 1 1.00027 6.37616 1.00027 22.5C1.00027 38.6238 6.41367 44 22.6492 44C38.8847 44 44.2981 38.6238 44.2981 22.5C44.2981 6.37616 38.8847 1 22.6492 1Z\" stroke=\"#6C6C8B\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>\n" +
                    "<path d=\"M26.0239 14.4306C26.0239 14.4306 17.8652 19.9904 17.8652 22.5007C17.8652 25.0109 26.0239 30.5661 26.0239 30.5661\" stroke=\"#6C6C8B\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>\n" +
                    "</svg>\n</button>",
                nextArrow: "<button type='button' class='slick-next'><svg width=\"46\" height=\"45\" viewBox=\"0 0 46 45\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\n" +
                    "<path fill-rule=\"evenodd\" clip-rule=\"evenodd\" d=\"M23.3511 1C39.5866 1 45 6.37616 45 22.5C45 38.6238 39.5866 44 23.3511 44C7.11555 44 1.70215 38.6238 1.70215 22.5C1.70215 6.37616 7.11555 1 23.3511 1Z\" stroke=\"#4C4C67\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>\n" +
                    "<path d=\"M19.9763 14.4306C19.9763 14.4306 28.135 19.9904 28.135 22.5007C28.135 25.0109 19.9763 30.5661 19.9763 30.5661\" stroke=\"#4C4C67\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>\n" +
                    "</svg>\n</button>",
                responsive: [
                    {
                        breakpoint: 1399,
                        settings: {
                            slidesToShow: 3.5,
                            slidesToScroll: 3

                        }
                    },
                    {
                        breakpoint: 991,
                        settings: {
                            slidesToShow: 2.5,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2,
                            arrows: false
                        }
                    }
                ]
            });
        });
    });



})(jQuery);
