jQuery(function($) {
    "use strict";
    var options = {
        offset: 600,
        classes: {
            clone: 'banner--clone',
            stick: 'banner--stick',
            unstick: 'banner--unstick'
        }
    };
    var banner = new Headhesive('.navbar', options);
    $('.bs-carousel').carousel({
        interval: 10000,
        pause: "hover"
    });
    if ($(".accordion").length > 0) {
        $('.accordion').accordion();
    }
    $('.venobox').venobox({
        autoplay: true
    });
    $('.social-share').click(function(event) {
        $(this).find('a').hide();
        $('.social-share .share').fadeIn('slow');
        $('.social-share .share a').fadeIn('slow');
        return false;
    });
    $(window).on('load resize scroll', function() {
        $('#newIn').not('.slick-initialized').slick({
            autoplay: false,
            autoplaySpeed: 3000,
            slidesToShow: 4,
            centerPadding: '60px',
            prevArrow: '<i class="material-icons left">keyboard_arrow_left</i>',
            nextArrow: '<i class="material-icons right">keyboard_arrow_right</i>',
            responsive: [{
                breakpoint: 768,
                settings: {
                    slidesToShow: 2
                }
            }, {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1
                }
            }]
        });
        $('#comingSoon').not('.slick-initialized').slick({
            autoplay: false,
            slidesToShow: 6,
            centerPadding: '60px',
            prevArrow: '<i class="material-icons left">keyboard_arrow_left</i>',
            nextArrow: '<i class="material-icons right">keyboard_arrow_right</i>',
            responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 4
                }
            }, {
                breakpoint: 768,
                settings: {
                    slidesToShow: 3
                }
            }, {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2
                }
            }]
        });
        $('.gallery').not('.slick-initialized').slick({
            autoplay: false,
            slidesToShow: 6,
            centerPadding: '60px',
            prevArrow: '<i class="material-icons left">keyboard_arrow_left</i>',
            nextArrow: '<i class="material-icons right">keyboard_arrow_right</i>',
            responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 4
                }
            }, {
                breakpoint: 768,
                settings: {
                    slidesToShow: 3
                }
            }, {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2
                }
            }]
        });
        $('.news-carousel').not('.slick-initialized').slick({
            autoplay: false,
            autoplaySpeed: 3000,
            slidesToShow: 3,
            centerPadding: '60px',
            prevArrow: '<i class="material-icons left">keyboard_arrow_left</i>',
            nextArrow: '<i class="material-icons right">keyboard_arrow_right</i>',
            responsive: [{
                breakpoint: 768,
                settings: {
                    slidesToShow: 2
                }
            }, {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1
                }
            }]
        });
    });
    var $nav = $('.nav').height();
    $('.nav').css('margin-top', -$nav / 2);
    $(window).on('load resize scroll', function() {
        var $heading = $('.wrapper .heading').outerHeight();
        var $navbar = $('.wrapper .navbar-header').outerHeight();
        $('#hero .item, #hero.single-page .blurb, #hero.error-page .container').css('padding-top', $heading + $navbar);
        var $window = $(window).height();
        $('#hero').css('height', window.innerHeight - 50);
        $('#hero.error-page').css('height', window.innerHeight);
    });
    if ($("#map").length > 0) {
        $("#map").gmap3({
            map: {
                options: {
                    zoom: 14,
                    center: new google.maps.LatLng(51.513614, -0.136549),
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    mapTypeControlOptions: {
                        mapTypeIds: [google.maps.MapTypeId.ROADMAP, "style1"]
                    },
                    styles: [{
                        "featureType": "all",
                        "elementType": "geometry",
                        "stylers": [{
                            "visibility": "simplified"
                        }, {
                            "hue": "#ff5c00"
                        }]
                    }, {
                        "featureType": "administrative",
                        "elementType": "all",
                        "stylers": [{
                            "visibility": "simplified"
                        }]
                    }, {
                        "featureType": "administrative.country",
                        "elementType": "labels.text.fill",
                        "stylers": [{
                            "color": "#1d1d1d"
                        }]
                    }, {
                        "featureType": "administrative.province",
                        "elementType": "labels.text.fill",
                        "stylers": [{
                            "color": "#ffffff"
                        }, {
                            "visibility": "on"
                        }]
                    }, {
                        "featureType": "administrative.province",
                        "elementType": "labels.text.stroke",
                        "stylers": [{
                            "color": "#ff5f00"
                        }, {
                            "weight": "5.00"
                        }, {
                            "visibility": "on"
                        }]
                    }, {
                        "featureType": "administrative.locality",
                        "elementType": "labels.text.fill",
                        "stylers": [{
                            "color": "#ec7532"
                        }, {
                            "visibility": "on"
                        }]
                    }, {
                        "featureType": "administrative.locality",
                        "elementType": "labels.text.stroke",
                        "stylers": [{
                            "color": "#ffffff"
                        }, {
                            "visibility": "on"
                        }, {
                            "weight": "5.00"
                        }]
                    }, {
                        "featureType": "administrative.neighborhood",
                        "elementType": "labels.text",
                        "stylers": [{
                            "visibility": "on"
                        }]
                    }, {
                        "featureType": "administrative.neighborhood",
                        "elementType": "labels.text.fill",
                        "stylers": [{
                            "visibility": "on"
                        }, {
                            "color": "#ec7532"
                        }]
                    }, {
                        "featureType": "administrative.neighborhood",
                        "elementType": "labels.text.stroke",
                        "stylers": [{
                            "color": "#ffffff"
                        }, {
                            "visibility": "on"
                        }, {
                            "weight": "5.00"
                        }]
                    }, {
                        "featureType": "administrative.land_parcel",
                        "elementType": "geometry.fill",
                        "stylers": [{
                            "saturation": "64"
                        }]
                    }, {
                        "featureType": "landscape",
                        "elementType": "geometry",
                        "stylers": [{
                            "color": "#fafafa"
                        }]
                    }, {
                        "featureType": "poi",
                        "elementType": "all",
                        "stylers": [{
                            "visibility": "off"
                        }]
                    }, {
                        "featureType": "road",
                        "elementType": "geometry",
                        "stylers": [{
                            "color": "#2c2c2c"
                        }]
                    }, {
                        "featureType": "road",
                        "elementType": "geometry.fill",
                        "stylers": [{
                            "visibility": "on"
                        }, {
                            "color": "#d5d5d5"
                        }]
                    }, {
                        "featureType": "road",
                        "elementType": "geometry.stroke",
                        "stylers": [{
                            "visibility": "off"
                        }]
                    }, {
                        "featureType": "road",
                        "elementType": "labels",
                        "stylers": [{
                            "visibility": "on"
                        }, {
                            "color": "#ec7532"
                        }]
                    }, {
                        "featureType": "road",
                        "elementType": "labels.text.fill",
                        "stylers": [{
                            "color": "#4a4a4a"
                        }]
                    }, {
                        "featureType": "road",
                        "elementType": "labels.text.stroke",
                        "stylers": [{
                            "visibility": "on"
                        }, {
                            "color": "#ffffff"
                        }, {
                            "weight": "5.00"
                        }]
                    }, {
                        "featureType": "road",
                        "elementType": "labels.icon",
                        "stylers": [{
                            "visibility": "off"
                        }]
                    }, {
                        "featureType": "road.highway",
                        "elementType": "geometry.fill",
                        "stylers": [{
                            "color": "#fbbd61"
                        }, {
                            "visibility": "on"
                        }, {
                            "lightness": "-0"
                        }]
                    }, {
                        "featureType": "road.highway",
                        "elementType": "geometry.stroke",
                        "stylers": [{
                            "visibility": "on"
                        }, {
                            "color": "#ff4b14"
                        }, {
                            "lightness": "100"
                        }, {
                            "saturation": "-100"
                        }]
                    }, {
                        "featureType": "road.highway",
                        "elementType": "labels.text",
                        "stylers": [{
                            "color": "#ffffff"
                        }]
                    }, {
                        "featureType": "road.highway",
                        "elementType": "labels.text.fill",
                        "stylers": [{
                            "color": "#fbbd61"
                        }]
                    }, {
                        "featureType": "road.highway",
                        "elementType": "labels.text.stroke",
                        "stylers": [{
                            "visibility": "on"
                        }, {
                            "color": "#ffffff"
                        }, {
                            "saturation": "13"
                        }, {
                            "lightness": "-1"
                        }]
                    }, {
                        "featureType": "road.arterial",
                        "elementType": "geometry.stroke",
                        "stylers": [{
                            "color": "#ff5f00"
                        }, {
                            "visibility": "on"
                        }]
                    }, {
                        "featureType": "transit.station",
                        "elementType": "labels.icon",
                        "stylers": [{
                            "visibility": "off"
                        }]
                    }, {
                        "featureType": "transit.station.airport",
                        "elementType": "geometry.fill",
                        "stylers": [{
                            "visibility": "simplified"
                        }, {
                            "lightness": "4"
                        }, {
                            "saturation": "-100"
                        }]
                    }, {
                        "featureType": "water",
                        "elementType": "all",
                        "stylers": [{
                            "visibility": "off"
                        }]
                    }, {
                        "featureType": "water",
                        "elementType": "geometry.fill",
                        "stylers": [{
                            "color": "#e1e1e1"
                        }, {
                            "visibility": "on"
                        }]
                    }],
                    disableDefaultUI: false,
                    draggable: true,
                    scrollwheel: false,
                }
            },
            marker: {
                latLng: [51.513614, -0.136549],
                options: {
                    icon: new google.maps.MarkerImage("images/pin.svg", new google.maps.Size(45, 63, "px", "px")),
                }
            }
        });
    }
    var $rows = $('.movie-tabs');
    /*jQuery('#search').keyup(function() {
        var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
        $rows.show().filter(function() {
            var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
            return !~text.indexOf(val);
        }).hide();
    });*/
    jQuery('.single-slide').first().css({
        opacity: '1',
        height: 'auto',
        paddingBottom: '40px'
    }).siblings('.single-slide').css({
        opacity: '0',
        height: '0',
        paddingBottom: '0'
    });
    jQuery('#comingSoon div').first().css('opacity', '1').siblings().css('opacity', '.35');
    jQuery('#comingSoon div').click(function() {
        var currentClass = $(this).data("dynamicclass");
        $("div." + currentClass).css({
            opacity: '1',
            height: 'auto',
            paddingBottom: '40px'
        }).siblings('.single-slide').css({
            opacity: '0',
            height: '0',
            paddingBottom: '0'
        });
        $(this).css('opacity', '1').siblings().css('opacity', '.35');
        return false;
    });
});