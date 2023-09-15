$(document).ready(function() {

  $(".sidebar-parent-menu a").click(function(){
    var me_sidebar =$(this);
    $id = $(this).data('id');
    $(".sidebar-parent-menu i").not($(this).find('i')).addClass('fa-angle-down');
    $(".sidebar-parent-menu i").not($(this).find('i')).removeClass('fa-angle-up');
  	$(".sidebar-child-menu").not($(this).closest('li').find('.sidebar-child-menu')).css("display","none");
  	$(".sidebar-child-menu[data-content-id="+$id+"]").toggle( 'fast', function(){
      var $el = me_sidebar.find('i');
      if ($el.hasClass('fa-angle-down')) {
        $el.removeClass('fa-angle-down');
        $el.addClass('fa-angle-up');
      }else{
        $el.removeClass('fa-angle-up');
        $el.addClass('fa-angle-down');
      }
   });
  });

  $sidebarWidth = $("#sidebar").width();
 $(".container-fluid").not('.header').css("padding-left",$sidebarWidth + 20 +"px");

 $sidebarWidth1 = $("#header").height();
 $(".sidebar-menu").css("margin-top",$sidebarWidth1+"px");


  $("#sidebarCollapse").on("click", function() {
    $("#sidebar").slideToggle('slow','swing',function(){
        if($("#sidebarCollapse").hasClass('active')){
          $("#sidebarCollapse").removeClass('active');
          $(".container-fluid").not('.header').animate({
            'padding-left' : $sidebarWidth + 20 +"px",
          }, "slow");
        }else{
          $("#sidebarCollapse").addClass('active');
          $(".container-fluid").not('.header').animate({
            'padding-left' : "10px",
          }, "slow");
        }
    });
  });


});
