
    $('.close').click(function(e) {
        setTimeout(() => {
            $('.overlayed, .popup, body').removeClass('active');
        }, 100)
        $('.overlayed').addClass('animation-closed')
        return false;
    });
    $('.overlayed').click(function(e) {
        var target = e.target || e.srcElement;
        if(!target.className.search('overlay')) {
            setTimeout(() => {
                $('.overlayed, .popup, body').removeClass('active');
            }, 100)
            $('.overlayed').addClass('animation-closed')
        } 
    });	
    $('[rel=popup]').click(function(e) {
        showPopup($(this).attr('data-popup'));
        return false;
    });

function showPopup(el) {
	if($('.popup').is('.active')) {
		$('.popup').removeClass('active');	
	}
	$('.overlayed, body, .popup.'+el).addClass('active');
    $('.overlayed').removeClass('animation-closed');
}