$(document).ready(function() {
    
    $(window).bind('load', function() {
        $(':animated').promise().done(function(){
            
            checkHash();
            getBottomDownload();
             
            setTimeout(function() {
                doneResizing();
            }, 1000);
        });
    });
    
    /**** show download ****/
    // $('.resume').hover(function() {
    //     $('.resume .download').css('display', 'block');
    // },
    // function(){
    //     $('.resume .download').hide();
    // });
    
    $('.block').hover(function() {
        $(this).addClass('active');
    },
    function(){
        $(this).removeClass('active');
    });
    
    
    $('footer li').hover(function() {
        $(this).parent().addClass('active');
    },
    function(){
        $(this).parent().removeClass('active');
    });
    
    
    
    function checkHash(){
        var hash = $(location).attr("hash").substring(1);
        filterTiles(hash);
    }
    $(window).bind('hashchange', function (){
       checkHash();
    });
   
    var $container = $('#blocksWrapper');
           
    $container.isotope({
        itemSelector : '.cont'
    });
    
    function filterTiles(selector) {
        if (selector === 'all' || selector === '') {
            $container.isotope({ filter: "*" });
        }
        else {
            $container.isotope({ filter: (".").concat(selector) });
        }
        $(':animated').promise().done(function(){
            clearTimeout(this.id);
            this.id = setTimeout(doneResizing, 1000);
        });
        
        $('#navWrapper a').removeClass('active');
        $('#navWrapper a').each(function(){
           if ($(this).attr('href') === ("#").concat(selector)){
               $(this).addClass('active');
               
               //calculate position of the marker
               var navigation = $('nav'),
               items = navigation.find('.item');
               var item = $(this).parent(),
                  index = items.index(item),
                  leftPoint = 0;
               
               if (items.length-1 === index) {
                   leftPoint = navigation.width() - item.outerWidth(true);
               } else if (index > 0) {
                   items.each(function(i, el) {
                       if (i >= index) {
                           return;
                       }
                       leftPoint += $(el).outerWidth(true);
                   });
               }
               
               $(".marker").stop().animate({left:leftPoint},200, function() {
                   $(".marker").stop().animate({display:'show'}, 200);
               });
               
           }
           else if (selector === '') {
               //$('#navWrapper li:nth-child(2) a').addClass('active');
               $('.marker').css('display', 'none');
           }
        });
        
        $('#navWrapper').removeClass();
        $('#navWrapper').addClass(selector);
        
        return false;
    }
    
    $(window).resize(function() {
        $(':animated').promise().done(function(){
            clearTimeout(this.id);
            this.id = setTimeout(doneResizing, 1000);
        });
        
        getBottomDownload();
    });    
    
    $('.block').hover(function(){
        $(this).addClass('flip');
    },function(){
        $(this).removeClass('flip');
    });  
    
     
    
    function doneResizing(){
        var hDocument = $('body').height(); // get the height of your content
        var hWindow = $(window).height(); // get the height of the visitor's browser window
        var hFooter = $('footer').height();
        var position = $('footer').css('position');
        //$('footer').css('bottom', '-120px');
        
        if (position === 'absolute'){
            if(hDocument>hWindow || hDocument+hFooter>hWindow) {
                $('footer').css('position', 'relative');
            }
            else {
                $('footer').css('position', 'absolute');
            }
        }
        else if(position === 'relative'){
            if(hDocument>hWindow){
               $('footer').css('position', 'relative');
            }
            else {
                $('footer').css('position', 'absolute');
            }
        }
        $('footer').css('bottom', '0');
    }
    
    /**** resume download scroll ****/
    
    $(window).scroll(function() {
        getBottomDownload();
    });
    
    function getBottomDownload() {
        var resumeHeight = $('#resumeWrapper').height();
        var windowHeight = $(window).height();
        var headerHeight = $('header').height();
        var navHeight = $('#navWrapper').height();
        var resumeBottom = headerHeight+navHeight+resumeHeight;
        var dist = 20;
        var scrolled = getScrollY();        
        var bottom;        
        
        if (windowHeight > resumeBottom) {
            bottom = dist;
        } 
        else if (windowHeight < resumeBottom)  {
            bottom = ((resumeBottom-windowHeight)+dist)-scrolled;
        }   
        
        if (bottom<0){
            bottom = dist;
        }
        
        $('.download').css('bottom',bottom+'px');
    }
    
    function getScrollY() {
        var scrOfX = 0, scrOfY = 0;
    
        if( typeof( window.pageYOffset ) == 'number' ) {
            //Netscape compliant
            scrOfY = window.pageYOffset;
        } else if( document.body && document.body.scrollTop ) {
            //DOM compliant
            scrOfY = document.body.scrollTop;
        } else if( document.documentElement && document.documentElement.scrollTop ) {
            //IE6 standards compliant mode
            scrOfY = document.documentElement.scrollTop;
        }
        return scrOfY;
    }
    
    
    
    $("label.inlined + .input-text").each(function (type) {
    
        $(window).bind('load', function () {
            setTimeout(function(){
                if (!input.value.empty()) {
                    input.previous().addClassName('has-text');
                }
            }, 200);
        });
                
        $(this).focus(function () {
            $(this).prev("label.inlined").addClass("focus");
        });
                
        $(this).keypress(function () {
            $(this).prev("label.inlined").addClass("has-text").removeClass("focus");
        });
                
        $(this).blur(function () {
            if($(this).val() === "") {
                $(this).prev("label.inlined").removeClass("has-text").removeClass("focus");
            }
        });
    });
    
    
    
    $('#contactWrapper form').submit(function() {
         
        $.ajax({
            url: "./php/send.php",
            data: "name=" + $(".name").val() + "&emailaddress=" + $(".emailaddress").val() + "&message=" + $(".message").val(),
            type: "POST",
            success: function(data) {
            
                var $message;
                if (JSON.parse(data) !== true) {                     
                    $message = "<div class=\"alert error\" style=\"opacity: 0\">There's something wrong!</div>";                    
                    showAlert($message);                   
                }
                else {                
                    $message = "<div class=\"alert\" style=\"opacity: 0\">Message sent successfully!</div>";
                    showAlert($message);
                    $('#contactWrapper form input[type=\"text\"]').val("");
                    $('#contactWrapper form input[type=\"email\"]').val("");
                    $('#contactWrapper form textarea').val("");
                }
            }
        });
        
        return false;
    });
    
    function showAlert($message) {
        console.log($('.alert').length);        
        
        if ($('.alert').length !== 0) {
            console.log('Alert gibts schon!');
            $('.alert').replaceWith( $message );
        }
        else {
            $('.contact').append( $message );                        
        }
        $('.alert').animate({'opacity': '1'}).delay(5000).animate({'opacity': '0'}).delay(1000).animate({'opacity': '0'}, {
                                                            duration: 1000,
                                                            step: function(){
                                                              $(this).remove();
                                                            }
                                                        });
    }
    
    // remove autofill mark in Safari and Chrome
    if(navigator.userAgent.toLowerCase().indexOf("chrome") >= 0 || navigator.userAgent.toLowerCase().indexOf("safari") >= 0){
        window.setInterval(function(){
            $('input:-webkit-autofill').each(function(){
                var clone = $(this).clone(true, true);
                $(this).after(clone).remove();
            });
        }, 20);
    }
    
    $('#contactWrapper form').attr('action', 'php/send.php');
    
});