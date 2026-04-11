(function ($) {
    function initSwiperForScope($scope) {
        var $container = $scope.find('.cus-post').first();
        var $next = $scope.find('.cus-next').first();
        var $prev = $scope.find('.cus-prev').first();

        if (!$container.length) {
            return;
        }

        if ($container[0].swiper && !$container[0].swiper.destroyed) {
            $container[0].swiper.destroy(true, true);
        }

        new Swiper($container[0], {
            slidesPerView: 'auto',
            spaceBetween: 16,
            loop: false,
            speed: 700,
            watchOverflow: true,
            observer: true,
            observeParents: true,
            slidesPerGroup: 1,
            navigation: {
                nextEl: $next[0],
                prevEl: $prev[0],
            },
            breakpoints: {
                0: {
                    slidesPerView: 'auto',
                    spaceBetween: 16
                }
            }
        });
    }

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/cus_swiper.default', function ($scope) {
            initSwiperForScope($scope);
        });
    });

    $(document).ready(function () {
        $('.elementor-widget-cus_swiper').each(function () {
            initSwiperForScope($(this));
        });
    });
})(jQuery);
