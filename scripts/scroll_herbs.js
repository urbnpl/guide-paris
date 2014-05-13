$(document).ready(function () {
    var myHeight;
    $('.element').each(function (i) {
        var myElement = $(this);
        myElement.data('params', {
            top1: $(this).css('top'),
            x1: $(this).css('left')
        });
        switch (i) {
        case 0:
            myElement.data('params', {
                top0: -1300,
                x0: -2600,
                top1: $(this).css('top'),
                x1: $(this).css('left')
            });
            break;
        case 1:
            myElement.data('params', {
                top0: 0,
                x0: -930,
                top1: $(this).css('top'),
                x1: $(this).css('left')
            });
            break;
        case 2:
            myElement.data('params', {
                top0: 280,
                x0: -1030,
                top1: $(this).css('top'),
                x1: $(this).css('left')
            });
            break;
        case 3:
            myElement.data('params', {
                top0: -1200,
                x0: -2330,
                top1: $(this).css('top'),
                x1: $(this).css('right')
            });
            break;
        case 4:
            myElement.data('params', {
                top0: 250,
                x0: -530,
                top1: $(this).css('top'),
                x1: $(this).css('right')
            });
            break;
        }
    });

    function init() {
        myHeight = $(window).height();
        $('header').css('height', myHeight - 300);
        $('section').css('min-height', Math.max(myHeight / 2 + 250, 600));
    }
    $(window).scroll(function () {
        var s_max = myHeight / 2 + 450;

        function move(p0, p1, s) {
            return Math.min((-p0 + p1) / s_max * s + p0, p1);
        }
        var scrollTop = parseInt($(window).scrollTop());
        $('.element').each(function (i) {
            var myX = move($(this).data('params').x0, parseInt($(this).data('params').x1), scrollTop),
                myY = move($(this).data('params').top0, parseInt($(this).data('params').top1), scrollTop);
            if (i < 3) {
                $(this).stop().css({
                    left: myX + 'px',
                    top: myY + 'px'
                })
            } else {
                $(this).stop().css({
                    right: myX + 'px',
                    top: myY + 'px'
                })
            }
        })
    })
    init();
    $(window).resize(function () {
        init();
    });
})