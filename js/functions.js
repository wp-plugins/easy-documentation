(function( $ ) {

    $(document).ready(function() {
        $('p.headline').click(function() {
            var clicked = $(this);
            var display_status = clicked.next().css('display');
            if( $('p.headline').length == 1) {
                if($('p.headline').next().css('display') =="block"){
                    $('.instructions').slideUp('slow');
                } else {
                    $('.instructions').slideDown('slow');
                }
            } else {
                $('p.headline').not(clicked).next().slideUp('500', function () {
                    if (display_status == "block") {
                        $('.instructions').slideUp('slow');
                    } else {
                        setTimeout(function () {
                            clicked.next().slideDown('slow');
                        }, '700');
                    }
                });
            }

        });

        $('img').mouseenter(function () {
            $(this).parent().next().find('span').addClass("selected");
        });
        $('img').mouseleave(function () {
            $(this).parent().next().find('span').removeClass("selected");
        });

        $('#warning_button').click( function() {
            $('.warning_box').fadeOut('slow');
            $.cookie('button_clicked', 'true');
        });

        var hashArray = [
            '#8abb00',
            '#008001',
            '#004964',
            '#460070',
            '#8b0067',
            '#ae0045',
            '#f00001',
            '#f58400',
            '#f7eb01'
        ];

        //if number of p.headline is greater than number of colorhashes in hashArray
        //for example if .headline has index 9 then give it hashArray[0], if has index 1 then give it hashArray[1] and so on
        function colorRepeat(index){
            if(index>8){
                index = index%9;
                return index;
            }
            else
                return index;
        }

        jQuery('.wpg_docs_content .headline').each(function(i) {
                    jQuery(this).css('border-color', hashArray[colorRepeat(i)]).fadeIn( 800 );
                });
        
        /* list scrolling function */
        $('p.headline').click(function() {
            var list_elem = $(this);
            setTimeout(function(){
                var odl = list_elem.offset().top;
                //console.log(odl);
                $('html, body').animate({
                    scrollTop: odl
                }, 1000);
            },'1000');
        });
    });
})( jQuery );