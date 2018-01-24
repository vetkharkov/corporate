@if(count($sliders) > 0)


    <div id="slider-cycle" class="slider cycle no-responsive slider_cycle group" style="height:485px;">
        <ul class="slider">


            @set($i, 1)

            @foreach($sliders as $slider)

                <li>
                    <div class="slide-holder"
                         style="background:  url('{{ asset(env('THEME')) }}/images/{{ $slider->img }}') no-repeat center center"
                         style="height:483px;">
                        <div class="slide-content-holder inner" style="height:483px;">
                            @if($i%2 !== 0)
                                <div class="slide-content-holder-content"
                                     style="position: absolute; top:30px;right:650px;">
                                    @else
                                        <div class="slide-content-holder-content"
                                             style="position: absolute; top:80px;left:500px;">
                                            @endif

                                            <div class="slide-title">
                                                {!! $slider->title !!}
                                            </div>
                                            <div class="slide-content" style="color:#fff">
                                                <p>{!! $slider->desc !!}</p>
                                            </div>

                                        </div>
                                </div>
                        </div>
                </li>

                @set($i, $i+1)
            @endforeach
        </ul>


        <script type="text/javascript">
            jQuery(document).ready(function ($) {

                var yit_slider_cycle_fx = 'easing',
                    yit_slider_cycle_speed = 800,
                    yit_slider_cycle_timeout = 3000,
                    yit_slider_cycle_directionNav = true,
                    yit_slider_cycle_directionNavHide = true,
                    yit_slider_cycle_autoplay = true;

                var yit_widget_area_position = function () {
                    $('#yit-widget-area').css({top: 33 - $('#yit-widget-area').height()});
                };
                $(window).resize(yit_widget_area_position);
                yit_widget_area_position();

                if ($.browser.msie && parseInt($.browser.version.substr(0, 1), 10) <= '8') {
                    $('#slider-cycle ul.slider').anythingSlider({
                        expand: true,
                        startStopped: false,
                        buildArrows: yit_slider_cycle_directionNav,
                        buildNavigation: false,
                        buildStartStop: false,
                        delay: yit_slider_cycle_timeout,
                        animationTime: yit_slider_cycle_speed,
                        easing: yit_slider_cycle_fx,
                        autoPlay: yit_slider_cycle_autoplay ? true : false,
                        pauseOnHover: true,
                        toggleArrows: false,
                        resizeContents: true
                    });
                } else {
                    $('#slider-cycle ul.slider').anythingSlider({
                        expand: true,
                        startStopped: false,
                        buildArrows: yit_slider_cycle_directionNav,
                        buildNavigation: false,
                        buildStartStop: false,
                        delay: yit_slider_cycle_timeout,
                        animationTime: yit_slider_cycle_speed,
                        easing: yit_slider_cycle_fx,
                        autoPlay: yit_slider_cycle_autoplay ? true : false,
                        pauseOnHover: true,
                        toggleArrows: yit_slider_cycle_directionNavHide ? true : false,
                        onSlideComplete: function (slider) {
                        },
                        resizeContents: true,
                        onSlideBegin: function (slider) {
                        },
                        onSlideComplete: function (slider) {
                        }
                    });

                }
            });
        </script>
        <div class="mobile-slider">
            <div class="slider fixed-image inner"><img
                        src="{{ asset(env('THEME'))}}/images/slider-cycle/cycle-fixed.jpg" alt=""/></div>
        </div>
@endif