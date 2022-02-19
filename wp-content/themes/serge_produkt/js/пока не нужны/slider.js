$(window).on("load", function() {

    $("#slider_wrap .img_loader").css("display", "none");
    setTimeout(function(){
        $('.slide img').css("opacity", "1");
    },900);

    $('.slide').css("opacity", "0").eq(0).css("opacity", "1").addClass('active_div');
    var slideNum = 0;
    slideCount = $("#slider .slide").length;
    function animSlide(arrow){
        clearTimeout(slideTime);
        $('.slide').eq(slideNum).css("opacity", "0");
        if(arrow == "next"){
            if(slideNum == (slideCount-1)){slideNum=0;}
            else{slideNum++}
            }
        else if(arrow == "prew")
        {
            if(slideNum == 0){slideNum=slideCount-1;}
            else{slideNum-=1}
        }
        else{
            slideNum = arrow;
            }
        if( slideNum == 0 ){
            $('.slide').eq(1).css("opacity", "0");
            $('.slide').eq(2).css("opacity", "0");
            $('.slide').eq(0).css("opacity", "1");

        } else if( slideNum == 1 ){
            $('.slide').eq(0).css("opacity", "0");
            $('.slide').eq(1).css("opacity", "1");
            $('.slide').eq(2).css("opacity", "0");

        } else if( slideNum == 2 ){
            $('.slide').eq(0).css("opacity", "0");
            $('.slide').eq(1).css("opacity", "0");
            $('.slide').eq(2).css("opacity", "1");
        }
        $('.slide').removeClass('active_div');
        $('.slide').eq(slideNum).addClass('active_div');
        $(".control-slide.active").removeClass("active");
        rotator();
        $('.control-slide').eq(slideNum).addClass('active');
    };

    var $adderSpan = '';
    $('.slide').each(function(index) {
            $adderSpan += '<div class = "control-slide">' + index + '</div>';
        });
    $('<div class ="sli-links">' + $adderSpan +'</div>').appendTo('#slider_wrap');
    $(".control-slide:first").addClass("active");
    $('.control-slide').on("click touchstart", function(){
    var goToNum = parseFloat($(this).text());
    animSlide(goToNum);
    return false;
    });
    function rotator(){
        slideTime = setTimeout(function(){animSlide('next')}, 10000);
    };
    rotator();

/////////////////////////////////////////////////////////////////////////////////////////////

    function slide_mayn() {
        $(".slide img").css("width","");
        $("#slider_wrap").css("height","");
        $(".sli-links").css("top","");
        $("#slider_wrap").find("#slider").css("width","");
        $("#slider_wrap").find("#slider").find(".slide").css({
            "width": "" , 
            "-webkit-transform": "",
            "-moz-transform": "",
            "-ms-transform": "",
            "-o-transform": "",
            "transform": ""
        });
        var massiv_size = ["0","300","400","500","600","700","800","900","1000","1100","1200","1300","1400","1600","1800",
            "2000","2500","3000","4000","5000","6000","7000","8000","99999"],
            img = $(".slide img"),
            img_h = img.height(),
            img_w = img.width(),
            wrap_div_img = $("#slider_wrap"),
            div_img = wrap_div_img.find("#slider"),
            div = div_img.find(".slide"),
            win_width = $(window).width(),
            win_height = screen.height,
            dots_slider = $(".sli-links");
            for( i=0; i<22; i++ ){
                if ((screen.width > massiv_size[i]) && (screen.width <= massiv_size[i+1])) {
                            data_width = 'data-'+massiv_size[i+1];
                            size = img.attr(data_width);
                            width = Math.ceil(size.split("x").shift());
                            height = Math.ceil(size.split("x").pop());
                }
            }
            
        if( screen.width > 900 ){

                var translatex_div = win_width*0.1;
                    img = $(".slide img");
                    s_w = screen.width;
                    original_w = img.attr('data-original-w');
                    original_h = img.attr('data-original-h');
                    img_w = s_w*1.2;
                    img_h = ((original_h*s_w)/original_w)*1.2;
                    img.css({"width": img_w + "px"});
                    wrap_div_img.css({"width": win_width, "height": (img_h/100)*98 });
                    div_img.css({"width": win_width, "height": img_h });
                    div.css({
                        "width": win_width, 
                        "height": img_h , 
                        "-webkit-transform": "translateX(-"+ translatex_div +"px)",
                        "-moz-transform": "translateX(-"+ translatex_div +"px)",
                        "-ms-transform": "translateX(-"+ translatex_div +"px)",
                        "-o-transform": "translateX(-"+ translatex_div +"px)",
                        "transform": "translateX(-"+ translatex_div +"px)"
                    });
                    
                    dots_slider.css("top", ( ((img_h/100)*90)/100)*97 );


        } else if( screen.width <= 900){
                var translatex_div = ((width*0.9) - win_width)/2;
                    wrap_div_img.css("height", height*0.88);
                    img.css({"width": width*0.9});
                    dots_slider.css("top", ( ((height/100)*90)/100)*85 );
                    wrap_div_img.css({"width": win_width});
                    div_img.css({"width": win_width });
                    div.css({
                        "width": win_width , 
                        "-webkit-transform": "translateX(-"+ translatex_div +"px)",
                        "-moz-transform": "translateX(-"+ translatex_div +"px)",
                        "-ms-transform": "translateX(-"+ translatex_div +"px)",
                        "-o-transform": "translateX(-"+ translatex_div +"px)",
                        "transform": "translateX(-"+ translatex_div +"px)"
                    });

        };
        slider_css_js_loaded();
    };
    slide_mayn();
    $(window).resize(function() {
        $(".slide img").on("load", function() {
            slide_mayn();
        });
    });
});