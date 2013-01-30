$(document).ready(function() {
    
    $(window).bind('load', function() {
        $(':animated').promise().done(function(){
            
            checkHash();
             
            setTimeout(function() {
                doneResizing();
            }, 1000);
        });
    });
    
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
});