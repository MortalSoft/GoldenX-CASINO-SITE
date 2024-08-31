<div class="wrapper">
	<style>
		.providersSlots {
		  background: #20273a;
		  border-radius: 15px;
		  margin-top: -40px;
		  padding: 40px 15px 70px 15px;
		  margin-bottom: 15px;
		  display: grid;
		  grid-template-columns: repeat(6,1fr);
		  grid-column-gap: 10px;
		  grid-row-gap: 10px;
		  z-index: 1;
		  position: relative;
		}
		@media (max-width: 1200px) {
		  .providersSlots {
		      grid-template-columns: repeat(5,1fr);
		  }}
		@media (max-width: 650px) {
		  .providersSlots {
		  grid-template-columns: repeat(4,1fr);
		}}
		@media (max-width: 450px) {
		  .providersSlots {
		    grid-template-columns: repeat(3,1fr);
		}}
		@media (max-width: 370px) {
		  .providersSlots {
		    grid-template-columns: repeat(2,1fr);
		}}
		.slots--notFound {
		  grid-column: 1 / -1;
		  text-align: center;
		  padding: 40px;
		  font-weight: 500;
		  font-size: 18px;
		}
		.providersSlots::after {
		  content: '';
		  position: absolute;
		  width: 100%;
		  height: 55px;
		  background: url(../images/shape-2.svg) no-repeat center center/contain;
		  -webkit-transform: rotate(180deg);
		  transform: rotate(360deg);
		  bottom: 0;
		}
		.providersSlots .provider {
		  background: #1b2030;
		  border-radius: 10px;
		  display: flex;
		  align-items: center;
		  justify-content: center;
		  padding: 10px;
		  height: 75px;
		  cursor: pointer;
		}
		.providersSlots .provider img {
		  width: 100%;
		  height: 100%;
		  transition: .2s;
		  object-fit: contain;
		  filter: grayscale(3);
		  opacity: .4;
		}
        .provider.active img {
            filter: grayscale(0);
            opacity: 1;
        }
		@media (max-width: 725px) {
		  .btn-up {
		    right: 20px;
		  }
		}
		.slots__container {
		  background: #20273a;
		  border-radius: 15px;
		}
		.slotsLeftBox {
		  display: flex;
		  margin: 10px;
		  align-content: center;
		  align-items: center;
		}
		.slotsLeftBox img{
		  width: 100%;
		  height: 100%;
		  border-radius: 15px;
		  object-fit: cover;
		}
		.slotsLeftBox span {
		  font-size: 1.25rem;
		  font-weight: 700;
		  margin-left: 10px;
		}
		.slotsLoad {
		  grid-column: 1 / -1;
		  height: 200px;
		  display: flex;
		  justify-content: center;
		  align-items: center;
		}
		.headSlots {
		  margin-bottom: 15px;
		  display: flex;
		  align-items: center;
		  background: #20273a;
		  justify-content: space-between;
		  border-radius: 15px;
		  height: 70px;
		  padding: 10px;
		  position: relative;
		  z-index: 2;
		}
		.searchSlots {
		  display: flex;
		  align-items: center;
		  width: 240px;
		  justify-content: space-between;
		  height: 50px;
		  border-radius: 8px;
		  padding: 0 20px;
		  background-color: #283046;
		}

		.searchSlots input {
		  height: 40px;
		  width: calc(100% - 3px);
		  border: 0px;
		  font-weight: 600;
          color: #fff;
		  background-color: transparent;
		}
		.slotsLoad .wave {
		  width: 2px;
		  height: 100px;
		  background: linear-gradient(45deg, #6080b0, #b7cdef);
		  margin: 10px;
		  animation: wave 1s linear infinite;
		  /* border-radius: 20px; */
		}
		.slotsLoad .wave:nth-child(2) {
		  animation-delay: 0.1s;
		}
		.slotsLoad .wave:nth-child(3) {
		  animation-delay: 0.2s;
		}
		.slotsLoad .wave:nth-child(4) {
		  animation-delay: 0.3s;
		}
		.slotsLoad .wave:nth-child(5) {
		  animation-delay: 0.4s;
		}
		.slotsLoad .wave:nth-child(6) {
		  animation-delay: 0.5s;
		}
		.slotsLoad .wave:nth-child(7) {
		  animation-delay: 0.6s;
		}
		.slotsLoad .wave:nth-child(8) {
		  animation-delay: 0.7s;
		}
		.slotsLoad .wave:nth-child(9) {
		  animation-delay: 0.8s;
		}
		.slotsLoad .wave:nth-child(10) {
		  animation-delay: 0.9s;
		}

		.btnSlots {
    cursor: pointer;
    border: 0px;
    height: 50px;
    border-radius: 8px;
    padding: 0 20px;
    width: 240px;
    font-weight: 600;
    font-size: 14px;
    margin-left: 10px;
    background: #f2ac44;
    color: #171b28;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: .25s ease;
		}
		.btnSlots.active svg {
		  transform: rotate(180deg);
		}
		.slots {
		    display: -ms-grid;
		    display: grid;
		    -ms-grid-columns: (1fr)[5];
		    grid-template-columns: repeat(5, 1fr);
		    grid-gap: 16px;
		    position: relative;
		    margin-bottom: 25px;
		    border-radius: 15px;
		}

		@media (max-width: 945px) {
		.slots {
		    -ms-grid-columns: (1fr)[3];
		    grid-template-columns: repeat(3, 1fr);
		}}
		@media (max-width: 580px) {
		.slots {
		    -ms-grid-columns: (1fr)[2];
		    grid-template-columns: repeat(2, 1fr);
		}}
		.slots_game {
		  height: 100%;
		  width: 100%;
		  max-height: 280px;
		  background: #1b2030;
		  position: relative;
		  border-radius: 15px;
		  overflow: hidden;
		  color: #fff;
		  transition: all .3s cubic-bezier(0.39, 0.58, 0.57, 1);
		}
		.slot__animation__play svg {
		  height: 60px;
		  width: 60px;
		  padding: 10px;
		  position: absolute;
		  top: 50%;
		  left: 50%;
		  margin-right: -50%;
		  transform: translate(-50%, -50%);
		}
		.slot__title {
		  font-weight: 700;
		  text-align: center;
		  left: 50%;
		  display: block;
		  color: #fff;
		  margin-top: 15px;
		  font-size: 19px;
		  position: absolute;
		  top: 18%;
		  margin-right: -50%;
		  transform: translate(-50%, -50%);
		}
		.slot__titleProvider {
		  font-weight: 700;
		  text-align: center;
		  left: 50%;
		  display: block;
		  color: #fff;
		  margin-top: 15px;
		  font-size: 19px;
		  position: absolute;
		  top: 68%;
		  margin-right: -50%;
		  transform: translate(-50%, -50%);
		}
		.slots_game:hover {
		  transform: scaleX(1.05) scaleY(1.05);
		}
		.slots_game:hover .slot__animation__play {
		  opacity: 1;
		}
		.slot__animation__play {
		  position: absolute;
		  left: 0;
		  right: 0;
		  top: 0;
		  bottom: 0;
		  opacity: 0;
		  backdrop-filter: blur(3px);
		  text-align: center;
		  transition: all .2s ease;
		  background-color: rgba(0,0,0,.3);
		}
		.slots_game img {
		  pointer-events: none;
		  height: 100%;
		    width: 100%;
		    border-radius: 15px;
		}
		.shape {
		  position: relative;
		}
		.shape span {
		  margin: 0;
		    position: absolute;
		    top: 20px;
		    left: 50%;
		    color: #6a809f;
		    font-size: 20px;
		    font-weight: 900;
		    text-transform: uppercase;
		    z-index: 1;
		    margin-right: -50%;
		    transform: translate(-50%, -50%);
		}
	</style>
	<div class="headSlots">
		<div class="searchSlots">
			<input type="text" onkeyup="searchSlot(this)" id="search-slots" placeholder="Поиск..." />
		</div>
		<button class="btnSlots btn is-ripples flare d-flex align-center has-ripple" data-color="#fff" data-opacity="0.1" data-duration="0.3" onclick="toggleProviders()">
			Провайдеры
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
				<polyline points="6 9 12 15 18 9"></polyline>
			</svg>
		</button>
	</div>
	<div class="providersSlots" style="display: none">
		<div class="provider" data-provider="" onclick="slotProvider(this)">
			<img src="/images/providers/allproviders.png" />
		</div>
		<div class="provider" data-provider="pragmatic" onclick="slotProvider(this)">
			<img src="/images/providers/pragmaticplay.png" />
		</div>
		<div class="provider" data-provider="netent" onclick="slotProvider(this)">
			<img src="/images/providers/netent.png" />
		</div>
        <div class="provider" data-provider="playngo" onclick="slotProvider(this)">
			<img src="/images/providers/playngo.png" />
		</div>
        <div class="provider" data-provider="redtiger" onclick="slotProvider(this)">
			<img src="/images/providers/redtiger.svg" />
		</div>
        <div class="provider" data-provider="relax" onclick="slotProvider(this)">
			<img src="/images/providers/relax.svg" />
		</div>
	</div>
	<!--<div class="slotsLoad">
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
    </div>-->
	<div class="shape">
		<div class="slots">
        </div>
	</div>
	<div class="slots__container" style="display: none;">
		<div style="display: flex;justify-content: space-between;align-items: center;">
			<div style="float: left;">
				<div class="slotsLeftBox">
					<div style="width: 4.563rem;height: 4.125rem;">
					</div>
					<span id="nameSlotsBox"></span>
				</div>
			</div>
			<div style="float: right;">
				<a style="margin: 10px;" href="/slots" class="btn d-flex align-center has-ripple" data-color="#6080B0" data-opacity="0.3" data-duration="0.3">
					<div style="transform: rotate(180deg);" class="btn__ico d-flex align-center justify-center">
						<svg class="icon"><use xlink:href="/images/symbols.svg?v=2#arrow_right"></use></svg>
					</div>
					<div class="btn__content">
						<span>Назад</span>
					</div>
				</a>
			</div>
		</div>
		<div class="default-screen-slot" style="display: block">
			<iframe style="borer-color: #20273a;width: 100%; border-radius: 0px 0px 15px 15px;display: none" src="" id="frameslot" webkitallowfullscreen="true" mozallowfullscreen="true" allowfullscreen="true" align="center" height="669.6">
				Ваш браузер не поддерживает плавающие фреймы!
			</iframe>
		</div>
	</div>
	<script type="text/javascript">
        var slots_observe = 0;
        var slots_page = 1;
        var slots_timeout = null;

		function open_url_slot() {
		    window.open($('button[data-url]').attr('data-url'))
		}

		function searchSlot(inp) {
		    clearTimeout(slots_timeout)

		    slots_timeout = setTimeout(() => {

		        $('.slotsLoad').show()
		        $('.slots').html('')
		        slots_page = 1
		        load_slots()

		    }, 500);
		}

		function slotProvider(e) {
		    let hasActive = $(e).hasClass('active')
		    slots_page = 1

		    $('.provider').removeClass('active')
		    $('.slots').html('')
		    $('.slotsLoad').show()

		    if(hasActive) {
		        return load_slots()
		    }

		    $(e).addClass('active')
		    load_slots()
		    //toggleProviders()
		}

		function toggleProviders() {
		    $('.btnSlots').toggleClass('active').css({pointerEvents: 'none'})

		    if($('.btnSlots').hasClass('active')) {
		        $('.providersSlots').slideDown(250)
		    } else {
		        $('.providersSlots').slideUp(250)
		    }

		    setTimeout(() => $('.btnSlots').css({pointerEvents: 'auto'}), 200)
		}

		function connectObserver() {
		    slots_observe = 1

		    var cb = function(entries, observer) {
		        if (entries[0].isIntersecting) {
		            load_slots()
		        }
		    };

		    let target = document.querySelector('.slots_game:last-child')
		    observer = new IntersectionObserver(cb);
		    observer.observe(target)
		}

		function load_slots() {
		    let attrs = {}
		    let search = $('#search-slots').val()
		    if(search) {
		        attrs['search'] = search
		    }

		    $('.slots__container').hide()

		    if(slots_observe) {
		        observer.disconnect();
		    }

		    $.post("/slots/getGames", {
		        _token: $('meta[name="csrf-token"]').attr("content"),
		        page: slots_page,
		        provider: $('.provider.active').attr('data-provider'),
		        ...attrs
		    })
		    .then(response => {
		        $(".slotsLoad").hide()
		        $(".slots").show()

		        response.games.map(item => {
		            $('.slots').append(
		                getSlotItem(item)
		            )
		        })

		        if(!response.games.length) {
		            $('.slots').html(
		                notFound()
		            )
		        }

		        if(response.games.length == 30) {
		            connectObserver()
		        }
		        slots_page++
		    });
		}

		function getSlotItem({ game_id, icon, title, provider }) {
		    return `
		        <a class="slots_game" target="#" style="cursor: pointer;" onclick="openSlot(${game_id})">
		            <img src="${icon}" />
		            <div class="slot__animation__play">
		            <svg class="icon"><use xlink:href="/images/symbols.svg?v=1#icon-play"></use></svg>
		                <div class="slot__title">${title}</div>
		                <div class="slot__titleProvider">${provider}</div>
		            </div>
		        </a>
		    `
		}

		function notFound() {
		    return `<div class="slots--notFound">Ничего не найдено</div>`
		}

		function openSlot(id) {
		    $.post('/slots/getUrl', {
		        _token: $('meta[name="csrf-token"]').attr("content"),
		        id
		    })
		    .then(response => {
				if(response.error) return;

				$('.slotsLoad').show()
		    	$(".shape, #frameslot").hide();
				$(".slots__container").show();
		    	$('.btnSlots').removeClass('active')
		    	$('.providersSlots').slideUp(250)
		        $('#frameslot').show()
                $('#frameslot').css('border-color', '#1b2030')
		        $('#balance').html('');
		        $('#nameSlotsBox').html(response.name);
		        $("#imagesSlotsBox").attr("src", response.image);
		        $("#frameslot").attr("src", response.url);
		        $('button[data-url]').attr('data-url', response.url)
		        $('.slotsLoad').hide()
		    })
		}

		load_slots();
	</script>
	<div class="btn-up" style="display:none">
		<div class="btn__ico d-flex align-center justify-center">
			<svg class="icon"><use xlink:href="../images/symbols.svg#arrow-up"></use></svg>
		</div>
	</div>
</div>