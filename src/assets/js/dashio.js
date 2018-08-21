var media_xm = window.matchMedia("(max-width: 575.98px)");
var media_sm = window.matchMedia("(min-width: 576px) and (max-width: 767.98px)");
var media_md = window.matchMedia("(min-width: 768px) and (max-width: 991.98px)");
var media_lg = window.matchMedia("(min-width: 992px) and (max-width: 1199.98px)");
var media_xl = window.matchMedia("(min-width: 1200px)");

function event_media_xm(media) {
    if (media.matches) return $(document).trigger('media:xm', [media]);else return $(document).trigger('media:xm:exit', [media]);
}
function event_media_sm(media) {
    if (media.matches) return $(document).trigger('media:sm', [media]);else return $(document).trigger('media:sm:exit', [media]);
}
function event_media_md(media) {
    if (media.matches) return $(document).trigger('media:md', [media]);else return $(document).trigger('media:md:exit', [media]);
}
function event_media_lg(media) {
    if (media.matches) return $(document).trigger('media:lg', [media]);else return $(document).trigger('media:lg:exit', [media]);
}
function event_media_xl(media) {
    if (media.matches) return $(document).trigger('media:xl', [media]);else return $(document).trigger('media:xl:exit', [media]);
}

$(document).ready(function () {
    event_media_xm(media_xm);
    media_xm.addListener(event_media_xm);

    event_media_sm(media_sm);
    media_sm.addListener(event_media_sm);

    event_media_md(media_md);
    media_md.addListener(event_media_md);

    event_media_lg(media_lg);
    media_lg.addListener(event_media_lg);

    event_media_xl(media_xl);
    media_xl.addListener(event_media_xl);
});

$(document).on('media:xm', function (event, media) {
    $('#btn-menu').on('click', function () {
        if ($(this).is('.menu-open, .menu-back')) {
            $('#menu').css('opacity', 0);

            $('#sidebar').addClass('d-flex').removeClass('d-none');
            $('#menu').addClass('d-flex').removeClass('d-none');
            $(this).addClass('menu-close').removeClass('menu-open').removeClass('menu-back');
            $('#menu').fadeTo('fast', 1);
        } else if ($(this).is('.menu-close')) {
            $('#menu').fadeTo('fast', 0, function () {
                $('#sidebar').addClass('d-none').removeClass('d-flex');
                $('#menu').addClass('d-none').removeClass('d-flex');
                $('#btn-menu').addClass('menu-open').removeClass('menu-close');
                $('#menu').css('opacity', 1);
            });
        }
    });
});
$(document).on('media:xm:exit', function (event, media) {
    $('#btn-menu').off('click');
});

$(document).on('media:xm media:lg media:xl media:sm media:md', function (event, media) {
    $('#desktop').removeClass('active');
    $(document).off('click.active-desktop');
    $('#sidebar').off('click.active-desktop');
    $('#menu .menu-item').off('click.active-desktop');
});

$(document).on('media:xm media:sm media:md', function (event, media) {
    $('#menu .menu-item').on('click.active-desktop', function () {
        console.log(10);
        $('#desktop').css('opacity', 0).addClass('active');
        $('#desktop').fadeTo('fast', 1);
        $(document).on('click.active-desktop', function (e) {
            if ($('#desktop').is('.active')) {
                $('#desktop').fadeTo('fast', 0, function () {
                    $(this).removeClass('active');
                    $(this).fadeTo('fast', 1);
                });
                $(document).off('click.active-desktop');
            }
        });
        if (media_xm.matches) {
            $('#btn-menu').addClass('menu-back').removeClass('menu-close').removeClass('menu-open');
        }
    });
    $('#sidebar').on('click.active-desktop', function (event) {
        event.stopImmediatePropagation();
    });
});

function myFunction(x) {
    if (x.matches) {
        document.body.style.backgroundColor = "yellow";
    } else {
        document.body.style.backgroundColor = "pink";
    }
}