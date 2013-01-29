$(document).ready(function() {
    
    $(window).bind('load', function() {
         $(':animated').promise().done(function(){
             doneResizing();
         });
    });
            
    var navigation = $('nav'),
       items = navigation.find('.item');
       //itemWidth = 150
    
    $(".item a").click(function(){
        var item = $(this).parent(),
           index = items.index(item),
           leftPoint = 0;
           
        $(".item a").removeClass('active');
        $(this).addClass('active');
    
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
    
    $('a[data-filter="*"]').click(function(){
        $('#navWrapper').css('background-color', '#980002');
    });

    $('a[data-filter=".webdev"]').click(function(){
        $('#navWrapper').css('background-color', '#e91348');
    });
    
    $('a[data-filter=".scripts"]').click(function(){
        $('#navWrapper').css('background-color', '#00c2f4');
    });
    
    $('a[data-filter=".photo"]').click(function(){
        $('#navWrapper').css('background-color', '#8b49ab');
    });
    
    $('a[data-filter=".ps"]').click(function(){
        $('#navWrapper').css('background-color', '#00cb66');
    });
    
   
   
   
    var $container = $('#blocksWrapper');
   
    // add randomish size classes
    $container.find('.block').each(function(){
        var $this = $(this),
           number = parseInt( $this.find('.number').text(), 10 );
        if ( number % 7 % 2 === 1 ) {
         $this.addClass('width2');
        }
        if ( number % 3 === 0 ) {
         $this.addClass('height2');
        }
    });
        
    $container.isotope({
        itemSelector : '.cont'
    });
     
    // filter items when filter link is clicked
    $('nav a').click(function(){
      var selector = $(this).attr('data-filter');
      $container.isotope({ filter: selector });
      $(':animated').promise().done(function(){
          clearTimeout(this.id);
          this.id = setTimeout(doneResizing, 1000);
      });
      return false;
    });

    
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
        
        //$('header').html("<div style=\"color: white;\">hDocument: "+hDocument+"<br>hWindow: "+hWindow+"<br>hFooter: "+hFooter+"<br>Position: "+position+"</div>");
        
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
        
        //$('header').html("<div style=\"color: white;\">hDocument: "+hDocument+"<br>hWindow: "+hWindow+"<br>hFooter: "+hFooter+"<br>Position: "+$('footer').css('position')+"</div>");
    }
   
});