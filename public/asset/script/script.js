$(document).ready(function(){
   
    let btn = $('#arrow');

    $(window).scroll(function(){
        if ($(window).scrollTop() > 300){
            btn.addClass('show');
        }else{
            btn.removeClass('show');
        }
    });

    btn.on('click', function(e) {
        e.preventDefault();
        $('body').animate({
            scrollTop: 0
        }, 500);
      });

});