import Lenis from '@studio-freight/lenis';
import gsap from "gsap";
import ScrollTrigger from "gsap/ScrollTrigger";

(function ($) {
    $.fn.initSmoothScroll = function (options) {
        const settings = $.extend({
            scrollDuration: 1200
        }, options);

        if (CCM_EDIT_MODE) {
            return;
        }

        gsap.registerPlugin(ScrollTrigger);

        const lenis = new Lenis({
            duration: settings.scrollDuration / 1000000,
            smooth: true,
            smoothWheel: true,
            smoothTouch: true,
        });

        lenis.on("scroll", ScrollTrigger.update);

        gsap.ticker.add((time) => {
            lenis.raf(time);
        });

        gsap.ticker.lagSmoothing(0);
    };
})(jQuery);