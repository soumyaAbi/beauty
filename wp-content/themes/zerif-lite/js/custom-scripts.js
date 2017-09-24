(function($){   
    $(document).load(function() {
        var teamHeight= 0,
        meetBlockHeight,
        meetContentHeight,
        meetDiff;
        function teamHeightSetter() {
            setTimeout(function() { 
                if (wW > 767) {
                    $('.awts-members ul li').each(function () {
                        if ($(this).height() > teamHeight) {
                           teamHeight = $(this).height(); 
                        }    
                    });
                    $('.awts-members ul li').height(teamHeight);
                }  
            }, 200);              
        }
        teamHeightSetter();
        function meetBlock() {
            if (wW > 1200) {
                $('.meet-block').height(667);
            }
            else if(wW > 1024) {
                $('.meet-block').height(561);
            }
             else if((wW < 1024) && (wW > 767)) {

                $('.meet-block').height(1.08*.5*wW);
            }
            else {
                $('.meet-block').height(auto);
            }
            meetBlockHeight = $('.meet-block').outerHeight();
            meetContentHeight = $('.meet-content').outerHeight();
            meetDiff = meetBlockHeight - meetContentHeight;
            $('.meet-content').css('top', meetDiff/2)
        }
        meetBlock();
        $(window).resize(function() {
            wW = $(window).width();
            teamHeightSetter();
            meetBlock();            
        });
    });
	$(document).ready(function() {
	 	var wW = $(window).width(),
            st = $(window).scrollTop(),
		lifestyleRatio,
		lsImgWidth,
		newsBlock,
		newsLetterBlock,
		orderPath,
		custLeftPath,
		custRightPath,
        videoHeight,
        catStr,
        count = 0,
        teamHeight= 0;
        function teamHeightSetter() {
            setTimeout(function() { 
                if (wW > 767) {
                    $('.awts-members ul li').each(function () {
                        if ($(this).height() > teamHeight) {
                           teamHeight = $(this).height(); 
                        }    
                    });
                    $('.awts-members ul li').height(teamHeight);
                }  
            }, 200);              
        }
        teamHeightSetter();

        // mobile menu click
        $('.navbar-toggle ').click(function() {
            $('body').toggleClass('activeMenu');
        });        
        
        $('.app-wrap .buttons a.btn').click(function(event) {
            event.preventDefault();
        });

        jQuery(".faqwd_categories_ul>li").on("click", function () {
            var data_id = $(this).attr('data-catid');
            var view_offset = $("#faqwd_category_head_li_"+data_id).position().top ;
            $('html, body').animate({
                  scrollTop: view_offset
            }, 1000); 
        });

        jQuery(".faqwd_category_scroll").on("click", function () {
            var view_offset = $(".faq-main").position().top ;
            $('html, body').animate({
                  scrollTop: view_offset
            }, 1000); 
        });
        

		// video in about us
	      $('.vid').click(function(){
	          video = '<iframe src="'+ $(this).attr('data-video') +'"></iframe>';
	          $(this).replaceWith(video);
                videoHeight = $('.video-wrap .col-xs-12').outerWidth() * 0.56;
                 $('.video-wrap iframe').height(videoHeight);
	      });

		// home page customization images
		$('.order-wrap path').click(function () {
            orderPath = $(this).context.className.animVal;
            function orderPathReset() {
            	d3.selectAll('.img_1').style('fill', '#d8d4d4');
            	d3.selectAll('.img_2').style('fill', '#d8d4d4');
            	d3.selectAll('.img_3').style('fill', '#d8d4d4');
            	d3.selectAll('.img_4').style('fill', '#d8d4d4');
            	$('.benefit-block').hide();
            	$('.order-wrap .col-sm-3 >img').removeClass();
            	$('.customization_sub_left > img').removeClass();
            }            
            if (orderPath.indexOf('img1') != -1) {
            	orderPathReset();
            	$('.order-wrap .col-sm-3 >img').addClass('top');             	
				$('.benefit-block-1').show();
            	d3.selectAll('.img_1').style('fill', '#1cbab3');
            } else if (orderPath.indexOf('img2') != -1){
            	orderPathReset(); 
            	$('.order-wrap .col-sm-3 >img').addClass('bottom');           	
				$('.benefit-block-2').show();        	
            	d3.selectAll('.img_2').style('fill', '#1cbab3');
            } else if (orderPath.indexOf('img3') != -1){
            	orderPathReset();
            	$('.order-wrap .col-sm-3 >img').addClass('left');              	
            	$('.benefit-block-3').show();
            	d3.selectAll('.img_3').style('fill', '#1cbab3');
            } else if (orderPath.indexOf('img4') != -1){
            	orderPathReset();
            	$('.order-wrap .col-sm-3 >img').addClass('right');
            	$('.benefit-block-4').show();
            	d3.selectAll('.img_4').style('fill', '#1cbab3');
            }

        });
        $('.customization_sub_left path').click(function () {
        	custLeftPath = $(this).context.className.animVal;
        	function custLeftPathReset() {
            	d3.selectAll('.cust-img-left-1').style('fill', '#d8d4d4');
            	d3.selectAll('.cust-img-left-2').style('fill', '#d8d4d4');
            	d3.selectAll('.cust-img-left-3').style('fill', '#d8d4d4');
            	d3.selectAll('.cust-img-left-4').style('fill', '#d8d4d4');
            	$('.customization_sub_left > img').removeClass();
            } 
            if (custLeftPath.indexOf('img1') != -1) {
            	custLeftPathReset();
            	$('.customization_sub_left > img').addClass('top');           	
            	d3.selectAll('.cust-img-left-1').style('fill', '#1cbab3');
            	$('.customization_sub_left > img').addClass('top');
            	$('.customization_sub_left > p').text('COLOR');
            } else if (custLeftPath.indexOf('img2') != -1){
            	custLeftPathReset(); 
            	$('.customization_sub_left > img').addClass('bottom');            	
            	d3.selectAll('.cust-img-left-2').style('fill', '#1cbab3');
            	$('.customization_sub_left > p').text('FINISH');
            } else if (custLeftPath.indexOf('img3') != -1){
            	custLeftPathReset();
            	$('.customization_sub_left > img').addClass('left');            	
            	d3.selectAll('.cust-img-left-3').style('fill', '#1cbab3');
            	$('.customization_sub_left > p').text('TRIM');
            } else if (custLeftPath.indexOf('img4') != -1){
            	custLeftPathReset();
            	$('.customization_sub_left > img').addClass('right');
            	d3.selectAll('.cust-img-left-4').style('fill', '#1cbab3');
            	$('.customization_sub_left > p').text('SIZE');

            }    
        });
        $('.customization_sub_right path').click(function () {
        	custRightPath = $(this).context.className.animVal;
        	function custRightPathReset() {
            	d3.selectAll('.cust-img-right-1').style('fill', '#ffffff');
            	d3.selectAll('.cust-img-right-2').style('fill', '#ffffff');
            	d3.selectAll('.cust-img-right-3').style('fill', '#ffffff');
            	d3.selectAll('.cust-img-right-4').style('fill', '#ffffff');
            	d3.selectAll('.cust-img-right-1').style('fill-opacity', 0.1);
            	d3.selectAll('.cust-img-right-2').style('fill-opacity', 0.1);
            	d3.selectAll('.cust-img-right-3').style('fill-opacity', 0.1);
            	d3.selectAll('.cust-img-right-4').style('fill-opacity', 0.1);
            	$('.customization_sub_right > img').removeClass();            	
            } 
            if (custRightPath.indexOf('img1') != -1) {
            	custRightPathReset();           	
            	d3.selectAll('.cust-img-right-1').style('fill', '#1cbab3');
            	d3.selectAll('.cust-img-right-1').style('fill-opacity', 1);
            	$('.customization_sub_right > img').addClass('top');            	
            	$('.customization_sub_right > p').text('WHITE');

            } else if (custRightPath.indexOf('img2') != -1){
            	custRightPathReset();            	
            	d3.selectAll('.cust-img-right-2').style('fill', '#1cbab3');
            	$('.customization_sub_right > img').addClass('bottom');            	
            	d3.selectAll('.cust-img-right-2').style('fill-opacity', 1); 
            	$('.customization_sub_right > p').text('BLACK');            	
            } else if (custRightPath.indexOf('img3') != -1){
            	custRightPathReset();           	
            	d3.selectAll('.cust-img-right-3').style('fill', '#1cbab3');
            	$('.customization_sub_right > img').addClass('left');            	
            	d3.selectAll('.cust-img-right-3').style('fill-opacity', 1);
            	$('.customization_sub_right > p').text('CREAM');            	 
            } else if (custRightPath.indexOf('img4') != -1){
            	custRightPathReset();
            	d3.selectAll('.cust-img-right-4').style('fill', '#1cbab3');
            	$('.customization_sub_right > img').addClass('right');
            	d3.selectAll('.cust-img-right-4').style('fill-opacity', 1);
            	$('.customization_sub_right > p').text('BROWN');
            }     
        });


	// for setting lifestyle bg image (1442:812) height
	function lifestyleBackground() {
	 	lifestyleRatio = parseFloat(812/1442);
	 	lsImgWidth = $('.lifestyle-img').outerWidth();
        if(wW > 992) {
            $('.lifestyle-img').height(lifestyleRatio * lsImgWidth);
        }
        else {
            $('.lifestyle-img').height(lifestyleRatio * lsImgWidth * 1);
        }
	} 
	lifestyleBackground();
	// for diagonal image
	function diagonal() {
		var diagonalWrapWidth = $('.diagonal_img').outerWidth(),
		    diagonalWrapHeight = $('.diagonal_img').outerHeight(),
		    diagonalSmallWrapWidth = $('.customize-wrap .diagonal_img').outerWidth(),
		    diagonalSmallWrapHeight = $('.customize-wrap .diagonal_img').outerHeight();

	}
	diagonal();

	function customizeBackground() {
		$('.customize-wrap').css('min-height', 0.46 * wW);
	}
	customizeBackground();
	function carouselWidth() {
		$('.amazingcarousel-item').width(.25 * wW);
		$('.amazingcarousel-image').height(.53 * .25 * wW);
	}
	carouselWidth();

	$(".buttons a.btn" ).on( "click", function() {
		$('.ytp-chrome-top').html('');
	});
    var benefitRight;
    function benefitBlock() {
        // console.log($('.all-block .col-sm-6:nth-child(3)').outerHeight());
        // benefitRight = $('.all-block .ben-right').outerHeight();
        // $('.all-block .col-sm-6:nth-child(2)').outerHeight(benefitRight);
    }
    benefitBlock();
    function newsBlockHeight() {
        var dd = $('.news-block').outerHeight();
        if (wW > 992) {
            newsLetterBlock = dd * (100/550) - 13;
        } else if(wW < 1100) {
            newsLetterBlock = dd * (100/550) - 8;
        }
        else {
            newsLetterBlock = dd * (100/550);
        }
        
        $('.news-block .btn').outerHeight(newsLetterBlock); 
        $('.news-block .email-input').outerHeight(newsLetterBlock);
        $('.newsletter-wrap .col-sm-3').outerHeight($('.newsletter-wrap .col-sm-9').outerHeight());
    }
	newsBlockHeight();
	$('.ug-carousel-wrapper').width('100%');
    $('.welcome_customer').on('click',  function() {
        $('.menu-top-menu-container').toggle();        
        if ($('.welcome_customer').hasClass('open')) {
            $('.welcome_customer').removeClass('open')
        } else {
            $('.welcome_customer').addClass('open')
        }
    });

    function signIn(){
        var signinRightHeight = $('.woocommerce .u-column2').outerHeight();
        $('.woocommerce .u-column1').outerHeight(signinRightHeight);
    }
    signIn();
    var meetBlockHeight,
    meetContentHeight,
    meetDiff;
    function meetBlock() {
        if (wW > 1200) {
            $('.meet-block').height(667);
        }
        else if(wW > 1024) {
            $('.meet-block').height(561);
        }
         else if((wW < 1024) && (wW > 767)) {

            $('.meet-block').height(1.08*.5*wW);
        }
        else {
        }
        meetBlockHeight = $('.meet-block').outerHeight();
        meetContentHeight = $('.meet-content').outerHeight();
        meetDiff = meetBlockHeight - meetContentHeight;
        $('.meet-content').css('top', meetDiff/2)
    }
    meetBlock();
    var benefitBlockHeight,
    benefitContentHeight,
    benefitDiff;
    function benefitBlockH() {
        if (wW > 1900) {
            $('#benefits .simple-block .col-sm-7').height(400);
        }
        else if (wW > 1200) {
            $('#benefits .simple-block .col-sm-7').height(430);
        }
        else if(wW > 900) {
            $('#benefits .simple-block .col-sm-7').height(351);
        }
         else if((wW < 900) && (wW > 767)) {

            $('#benefits .simple-block .col-sm-7').height(.6*.7*wW);
        }
        else {
        } 
        benefitBlockHeight = $('.simple-block .col-sm-7').outerHeight();
        benefitContentHeight = $('.simple-block .benefit-content').outerHeight();
        benefitDiff = benefitBlockHeight - benefitContentHeight;
        $('.benefit-content').css('top', benefitDiff/2);
    }
    benefitBlockH();
    var newsBHeight,
    newsCHeight,
    newsDiff;
    function newsBlockPos() {
        newsBHeight = $('.newsletter-wrap .col-sm-9').outerHeight();
        newsCHeight = $('.newsletter-wrap .news-block').outerHeight();
        newsDiff = parseInt(newsBHeight) - parseInt(newsCHeight);
        if (wW > 767) {
            $('.newsletter-wrap .news-block').css('top', newsDiff/2);
        }
    }
    newsBlockPos();

    
    $( ".reset_variations" ).remove();
    $('.variations tr').each(function() {
        $(':radio').each(function(){
            if($(this).is(':checked')) {
                $(this).parent().parent().find('div:last-child').text($(this).parent().find('label').text());
            }
        })
    });  
   
    $(".variations :radio").click(function() {
        if(this.checked) {
            $(this).parent().parent().find('div:last-child').text($(this).parent().find('label').text());
        }
    });
    $('.tech-spec-top .tech-spec-pagination span').on('click', function() {
        
        $('.tech-spec-top .tech-spec-pagination span').removeClass('active');
        $(this).addClass('active');
        $('#th-page .tech-spec-top > .container > .row > .col-sm-6').hide();
        if ($(this).hasClass('first')) {
            $('#th-page .tech-spec-top > .container > .row > .col-sm-6:nth-child(1)').show();
        } else {
            $('#th-page .tech-spec-top > .container > .row > .col-sm-6:nth-child(2)').show();

        }
    });
    $('#th-home.caption__overlay').on('click', function() {
        $('#th-home #main-nav').css('z-index', 2);
    });
    $('#th-home .modal').on('click', function() {
        $('#th-home #main-nav').css('z-index', 6);
    });
    
    $(".thrd-pa_size-solo-100-items, .thrd-pa_size-solo-200-items").click(function() {
        
        var solo_val = $(this).attr('id');

        var solo_label = $("label[for='"+solo_val+"']").text();

        solo_attrs = solo_label.split('(');

        $('.thrd-prd-type').text(solo_attrs[0]);

        solo_capacity = solo_label.match(/\d+/);

        $('.capacity-num').text(solo_capacity);

        $('.capacity-image').removeClass().addClass('capacity-image cap-'+solo_capacity)

    });

    $(".thrd_cart_pay_type").live('change', function() {

        $('#cart_total_frm').submit();
    });

    var dataurl, lblWidth = 0;
    $('.videos-block .col-sm-4 img').click(function(){        
        dataurl = $(this).parent().parent().find('.iframe-vid').attr('src') + "&autoplay=1";
        $(this).parent().parent().find('.iframe-vid').attr('src', dataurl);
        $(this).hide();
    });

	$(window).resize(function() {
		wW = $(window).width();
        signIn();
	 	lifestyleBackground();
	 	diagonal();
		customizeBackground();
		carouselWidth();
		newsBlockHeight();
        // orderMobile();
        // carouselControls();
        // benefitImageChange();
        benefitBlock();
        meetBlock();
        benefitBlockH(); 
        newsBlockPos(); 
        // labelWidth();  
        // preorderMobile();
        teamHeightSetter();
	});
    function headerPosition() {
    if (wW > 767) {
        if (st >= 50) {
            $('#main-nav').addClass('black_bg');
        } else {
            $('#main-nav').removeClass('black_bg');
        }
    } 
    else {
         $('#main-nav').removeClass('black_bg');
    }          
    }
    headerPosition();
	// for header background
	$(window).scroll(function() {
	    st = $(window).scrollTop();
          headerPosition();	    
	});
	
	});

    $('.quantity-button').live('click', function() {
        thr_id = $(this).attr('id');
        $this = $(this);
        var qty = $this.parent().parent().find('.qty');
        var cur_qty = parseFloat(qty.val());
        if(thr_id == 'up') {
            qty.val(cur_qty+1);
            qty.trigger("change");
        } else if(thr_id == 'down' && cur_qty > 0) {
            qty.val(cur_qty-1);
            qty.trigger("change");
        }
    });
})(jQuery);



