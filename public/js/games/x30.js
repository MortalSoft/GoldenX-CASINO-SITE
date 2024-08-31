newGame();
function newGame () {
    var time = 30;
    const timer = setInterval(() => {
        time--
        if (time <= 0) {
            clearInterval(timer);
            sliderWheel();
        }
        $('#x30__timer').html(time)
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
                $('#x30__status').removeClass('x30__rocket--started');
            }, 1500)
        }
        $('#x30__timer').html(time)
    }, 1000)
    $('#x30__text').html('Прокрутка');
    $('#x30__status').addClass('x30__rocket--started');
    $('#x30__wheel').css({'transform':'rotate('+ getRandomInt(600, 1200) +'deg)'});
}