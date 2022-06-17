$('#slider-2').slick({
  infinite: true,
  slidesToShow: 1,
  slidesToScroll: 1,
  prevArrow:'<span class="prev-arrow"><i class="fa-solid fa-arrow-left"></i></span>',
  nextArrow:'<span class="next-arrow"><i class="fa-solid fa-arrow-right "></i></span>',
});
  //  $('#banner-slider').slick({
  //      dots: true,
  //      infinite: true,
  //      speed: 300,
  //      arrows:false,
  //      slidesToShow: 1,
  //      prevArrow:'.arrow-1',
  //      text:'<span>454</span>',
  //      nextArrow:'.arrow-2',
  //  });

   $('#banner-slider').slick({
          dots: true,
          infinite: true,
          slidesToShow: 1,
          slidesToScroll: 1,
          nextArrow: '.arrow-2',
          prevArrow: '.arrow-1',
  });