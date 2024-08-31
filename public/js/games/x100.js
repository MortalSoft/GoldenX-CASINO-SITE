newGame();
function newGame () {
    var time = 30;
    const timer = setInterval(() => {
        time--
        if (time <= 0) {
            clearInterval(timer);
            sliderWheel();
        }
        $('#x100__timer').html(time)
    }, 1000)
    $('#x30__text').html('Начало через');
}

function sliderWheel () {
    var time = 30;
    const timer = setInterval(() => {
        time--
        if (time <= 0) {
            clearInterval(timer);
            setTimeout(() => {
                newGame();
                $('#x100__status').removeClass('x30__rocket--started');
            }, 1500)
        }
        $('#x100__timer').html(time)
    }, 1000)
    $('#x100__text').html('Прокрутка');
    $('#x100__status').addClass('x30__rocket--started');
    $('#x100__wheel').css({'transform':'rotate('+ getRandomInt(600, 1200) +'deg)'});
}