$(function (){
   $("a").on("click", function (e){
       e.preventDefault();
       if ($(this).attr('id') === 'profileDropdown'){
           $(this).parent().toggleClass('show');
           $('div[aria-labelledby="profileDropdown"]').toggleClass('show');
       }
       if ($(this).hasClass('nav-link') && typeof $(this).attr('data-browse') !== "undefined"){
           let location = 'index.php?page=' + $(this).attr('data-browse') + '&id=' + $(this).attr('data-id');
           window.location.href = location;
       }
       else{
           window.location.href = $(this).prop('href');
       }
   });

   $(".navbar-toggler").on("click", function (){
       $("body").toggleClass("sidebar-icon-only");
       if ($("body").hasClass("sidebar-icon-only")){
           $(".arrow_sidebar").css("display", "none");
       }else{
           $(".arrow_sidebar").css("display", "block");
       }

   })
});