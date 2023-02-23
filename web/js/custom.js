

//$(window).scroll(function() {

	//if ($(window).scrollTop() > 44) {
	//			$('.main-menu').addClass("active");
	//			$('header').addClass("active");
	//}
	//else{
	//	$('.main-menu').removeClass("active");
	//	$('header').removeClass("active");
	//}
//});
	$(".ml-auto>.nav-item a").click(function(){
		var xiabiao=$(".ml-auto>.nav-item a").index();
	    $(".ml-auto>.nav-item a").eq(xiabiao).addClass("active1").siblings().removeClass("active1");
	})
	$(".lei>.nav-tabs li").click(function(){
		var biao=$(".lei>.nav-tabs li").index();
	    $(".lei>.nav-tabs li").eq(biao).addClass("bg").siblings().removeClass("bg");
	})
	$(".ger").mouseover(function(){
		$(this).show();
	})
//  if (screen.width > 1024) {
// if ( $('.portipolio-sec').length > 0 ) {

//    AOS.init({
//         easing: 'ease-in-out-sine'
//       });
// }
//  }

if ( $('.videos-sec').length > 0 ) {
	$.wmBox();
}
