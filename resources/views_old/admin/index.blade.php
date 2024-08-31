@php
$setting = \App\Setting::first();
@endphp

<div class="content" >
	<div class="flex " >
		<div class="col" style="max-width: 100%;margin: 0px auto;">
			<div class="flex no_padding wrap">
				<div class="col">
					<div class="flex no_padding wrap">
						<div class="col-lg-4">
							<div class="content-area " >
								<span class="text-secondary text-admin-title">Dice + Mines </span>
								<div class="hr"></div>
								<div class="flex no_padding">
									<div class="col">
										<span class="text-secondary text-admin-title">Банк</span>
										<span class="text-secondary text-admin-title" id="dice_bank" style="color: black;font-size:35px;margin-top: 10px;margin-bottom: 30px;display: block;">{{$setting->dice_bank}}</span>
									</div>
									<div class="col">
										<span class="text-secondary text-admin-title">Заработок</span>
										<span class="text-secondary text-admin-title" id="dice_profit" style="color: black;font-size:35px;margin-top: 10px;margin-bottom: 30px;display: block;">{{$setting->dice_profit}}</span>
									</div>
								</div>
								<button class="btn-dep w-100" onclick="resetBank('dice')">Обнулить письку</button>
								<div class="flex no_padding" style="margin-top:10px">
									<button onclick="updateAuto(1, 'dice', this)" style="border-radius: 10px 0px 0px 10px;" class="btn-dice w-100 @if($setting->auto_dice == 1) btn-auth @else btn-dep @endif">Включить письку</button>
									<button onclick="updateAuto(0, 'dice', this)" s style="border-radius: 0px 10px 10px 0px;" class="btn-dice w-100 @if($setting->auto_dice == 0) btn-auth @else btn-dep @endif">Отключить письку</button>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="content-area " >
								<span class="text-secondary text-admin-title">Mines</span>
								<div class="hr"></div>
								<div class="flex no_padding">
									<div class="col">
										<span class="text-secondary text-admin-title">Банк</span>
										<span class="text-secondary text-admin-title" id="mines_bank" style="color: black;font-size:35px;margin-top: 10px;margin-bottom: 30px;display: block;">{{$setting->mines_bank}}</span>
									</div>
									<div class="col">
										<span class="text-secondary text-admin-title">Заработок</span>
										<span class="text-secondary text-admin-title" id="mines_profit" style="color: black;font-size:35px;margin-top: 10px;margin-bottom: 30px;display: block;">{{$setting->mines_profit}}</span>
									</div>
								</div>
								<button class="btn-dep w-100" onclick="resetBank('mines')">Обнулить письку</button>
								<div class="flex no_padding" style="margin-top:10px">
									<button onclick="updateAuto(1, 'mines', this)" s style="border-radius: 10px 0px 0px 10px;" class="btn-mines w-100 @if($setting->auto_mines == 1) btn-auth @else btn-dep @endif">Включить письку</button>
									<button onclick="updateAuto(0, 'mines', this)" s style="border-radius: 0px 10px 10px 0px;" class="btn-mines w-100 @if($setting->auto_mines == 0) btn-auth @else btn-dep @endif">Отключить письку</button>
								</div>

								<div class="flex no_padding" style="margin-top:10px">
									<input type="" id="idMinesBonus" style="border-radius: 10px 0px 0px 10px;"  placeholder="ID человека" class="secodary_input w-100"  name="">
									<button onclick="giveBonusMines()" style="border-radius: 0px 10px 10px 0px;" class="btn-auth w-100">Выдать письку</button>
								</div>

							</div>
						</div>
						<div class="col-lg-4">
							<div class="content-area " >
								<span class="text-secondary text-admin-title">x30</span>
								<div class="hr"></div>
								<div class="flex no_padding">
									<div class="col">
										<span class="text-secondary text-admin-title">Банк</span>
										<span class="text-secondary text-admin-title" id="wheel_bank" style="color: black;font-size:35px;margin-top: 10px;margin-bottom: 30px;display: block;">{{$setting->wheel_bank}}</span>
									</div>
									<div class="col">
										<span class="text-secondary text-admin-title">Заработок</span>
										<span class="text-secondary text-admin-title" id="wheel_profit" style="color: black;font-size:35px;margin-top: 10px;margin-bottom: 30px;display: block;">{{$setting->wheel_profit}}</span>
									</div>
								</div>
								<button class="btn-dep w-100" onclick="resetBank('wheel')">Обнулить письку</button>
								<div class="flex no_padding" style="margin-top:10px">
									<button onclick="updateAuto(1, 'wheel', this)" s style="border-radius: 10px 0px 0px 10px;" class="btn-wheel w-100 @if($setting->auto_wheel == 1) btn-auth @else btn-dep @endif">Включить письку</button>
									<button onclick="updateAuto(0, 'wheel', this)" s style="border-radius: 0px 10px 10px 0px;" class="btn-wheel w-100 @if($setting->auto_wheel == 0) btn-auth @else btn-dep @endif">Отключить письку</button>
								</div>
							</div>
						</div>
					</div>
					<div class="content-area " >
						<span class="text-secondary text-admin-title">Стата GamePay</span>
						<div class="hr"></div>
						<span class="text-secondary text-admin-title">Общий баланс кошельков</span>
						<span class="text-secondary text-admin-title" style="color: black;font-size:35px;margin-top: 10px;margin-bottom: 30px;display: block;">100000</span>

						<small class="text-secondary" style="font-size: 11px;">* Информация обновляется раз в 5 минут</small>
						


					</div>
					
					<div class="content-area " >
						<div class="flex no_padding wrap">

							<div class="col-lg-6"> 

								<span class="text-secondary text-admin-title">Онлайн</span>
								<span class="text-secondary text-admin-title online" style="color: black;font-size:35px;margin-top: 10px;margin-bottom: 30px;display: block;" ></span>

								<div class="flex no_padding wrap">
									<div class="col-lg-5">
										<div class="flex no_padding">
											<div class="col"><span class="text-secondary text-admin-title">Пользователей всего</span></div>
											<div class="col col-3 text-right text-secondary text-admin-title">{{\App\User::count()}} (<span class="text-danger"> {{\App\User::where('ban', 1)->count()}} </span>)</div>
										</div>
										<div class="hr"></div>

										<div class="flex no_padding">
											<div class="col"><span class="text-secondary text-admin-title">Пользователей за сегодня</span></div>
											<div class="col col-3 text-right text-secondary text-admin-title">22 (<span class="text-danger"> 1 </span>)</div>
										</div>
										<div class="hr"></div>
										<div class="flex no_padding">
											<div class="col"><span class="text-secondary text-admin-title">Пользователей за неделю</span></div>
											<div class="col col-3 text-right text-secondary text-admin-title">22 (<span class="text-danger"> 1 </span>)</div>
										</div>
										<div class="hr"></div>

										<div class="flex no_padding">
											<div class="col"><span class="text-secondary text-admin-title">Пользователей за месяц</span></div>
											<div class="col col-3 text-right text-secondary text-admin-title">22 (<span class="text-danger"> 1 </span>)</div>
										</div>
										<div class="hr"></div>

										<div class="flex no_padding">
											<div class="col"><span class="text-secondary text-admin-title">Пользователей за год</span></div>
											<div class="col col-3 text-right text-secondary text-admin-title">22 (<span class="text-danger"> 1 </span>)</div>
										</div>

										<small class="text-secondary" style="font-size: 11px;">* Красным цветом обозначаются забаненные пользователи</small>
										

									</div>

									<div class="col-lg-5">
										<div class="flex no_padding">
											<div class="col"><span class="text-secondary text-admin-title">Игр всего</span></div>
											<div class="col col-3 text-right text-secondary text-admin-title">22</div>
										</div>
										<div class="hr"></div>

										<div class="flex no_padding">
											<div class="col"><span class="text-secondary text-admin-title">Игр за сегодня</span></div>
											<div class="col col-3 text-right text-secondary text-admin-title">22</div>
										</div>
										<div class="hr"></div>
										<div class="flex no_padding">
											<div class="col"><span class="text-secondary text-admin-title">Игр за неделю</span></div>
											<div class="col col-3 text-right text-secondary text-admin-title">22</div>
										</div>
										<div class="hr"></div>

										<div class="flex no_padding">
											<div class="col"><span class="text-secondary text-admin-title">Игр за месяц</span></div>
											<div class="col col-3 text-right text-secondary text-admin-title">22</div>
										</div>
										<div class="hr"></div>

										<div class="flex no_padding">
											<div class="col"><span class="text-secondary text-admin-title">Игр за год</span></div>
											<div class="col col-3 text-right text-secondary text-admin-title">22</div>
										</div>
										

									</div>
								</div>
							</div>
							<div class="col-lg-1_4">
								<span class="text-secondary text-admin-title">Топ 5 богатых писек</span>
								@php
								$user_bogat = \App\User::orderBy('balance', 'desc')->where('admin', '!=', 1)->limit(5)->get();					
								@endphp

								@foreach($user_bogat as $u)

								<div style="margin:20px 0px">									
									<div class="flex no_padding wrap">
										<div class="col" style="">
											<div class="block_history pointer" onclick="load('/admin/user/{{$u->id}}')">
												<div class="flex no_padding " style="height: 100%;">
													<div class="col text-center"><img src="{{$u->avatar}}" class=" img_ava middle_text "></div>
													<div class="col"><div class="text-secondary middle_text text-center">{{$u->name}}</div></div>
													<div class="col"><div class="text-secondary middle_text text-center" style="">{{$u->balance}}  <img src="img/coin.svg?v=5" style="position: relative;transform: translate(1px, 3px);"></div></div>
												</div>								
											</div>
										</div>
										
									</div>
									
								</div>


								@endforeach
								

								

								<div class="hr"></div>

								<span class="text-secondary text-admin-title">Топ 5 рефоводов по рефералам</span>

								@php
								$user_refs = \App\User::orderBy('refs', 'desc')->limit(5)->get();					
								@endphp

								@foreach($user_refs as $u)

								<div style="margin:20px 0px">									
									<div class="flex no_padding wrap">
										<div class="col" style="">
											<div class="block_history pointer" onclick="load('/admin/user/{{$u->id}}')">
												<div class="flex no_padding " style="height: 100%;">
													<div class="col text-center"><img src="{{$u->avatar}}" class=" img_ava middle_text "></div>
													<div class="col"><div class="text-secondary middle_text text-center">{{$u->name}}</div></div>
													<div class="col"><div class="text-secondary middle_text text-center" style="">{{$u->refs}} рефералов</div></div>
												</div>								
											</div>
										</div>
										
									</div>
									
								</div>


								@endforeach
								


								<div class="hr"></div>

								<span class="text-secondary text-admin-title">Топ 5 рефоводов по заработку</span>


								@php
								$user_profit = \App\User::orderBy('profit', 'desc')->limit(5)->get();					
								@endphp

								@foreach($user_profit as $u)

								<div style="margin:20px 0px">									
									<div class="flex no_padding wrap">
										<div class="col" style="">
											<div class="block_history pointer" onclick="load('/admin/user/{{$u->id}}')">
												<div class="flex no_padding " style="height: 100%;">
													<div class="col text-center"><img src="{{$u->avatar}}" class=" img_ava middle_text "></div>
													<div class="col"><div class="text-secondary middle_text text-center">{{$u->name}}</div></div>
													<div class="col"><div class="text-secondary middle_text text-center" style="">{{$u->profit}} p.</div></div>
												</div>								
											</div>
										</div>
										
									</div>
								</div>

								@endforeach



								<div class="hr"></div>
							</div>
						</div>
					</div>
					<div class="content-area">
						<div class="flex no_padding wrap">
							@php
							$deps = \App\Payment::where('status', 1)->sum('sum');
							$withdraws = \App\Withdraw::where('status', 1)->sum('sum');
							$profit = round($deps - $withdraws ,2);

							$deps_today = \App\Payment::where('status', 1)->whereDate('created_at', \Carbon\Carbon::today())->sum('sum');
							$withdraws_today = \App\Withdraw::where('status', 1)->whereDate('created_at', \Carbon\Carbon::today())->sum('sum');
							$profit_today = round($deps_today - $withdraws_today ,2);

							$deps_yesterday  = \App\Payment::where('status', 1)->whereDate('created_at', \Carbon\Carbon::yesterday())->sum('sum');
							$withdraws_yesterday  = \App\Withdraw::where('status', 1)->whereDate('created_at', \Carbon\Carbon::yesterday())->sum('sum');
							$profit_yesterday  = round($deps_yesterday  - $withdraws_yesterday ,2);

								
							$deps_week  = \App\Payment::where('status', 1)->whereBetween('created_at', [\Carbon\Carbon::now()->startOfWeek(), \Carbon\Carbon::now()->endOfWeek()])->sum('sum');
							$withdraws_week  = \App\Withdraw::where('status', 1)->whereBetween('created_at', [\Carbon\Carbon::now()->startOfWeek(), \Carbon\Carbon::now()->endOfWeek()])->sum('sum');
							$profit_week  = round($deps_week  - $withdraws_week ,2);

							$deps_month  = \App\Payment::where('status', 1)->whereMonth('created_at', \Carbon\Carbon::now()->month)->sum('sum');
							$withdraws_month  = \App\Withdraw::where('status', 1)->whereMonth('created_at', \Carbon\Carbon::now()->month)->sum('sum');
							$profit_month  = round($deps_month  - $withdraws_month ,2);

							$deps_year  = \App\Payment::where('status', 1)->whereYear('created_at', \Carbon\Carbon::now()->year)->sum('sum');
							$withdraws_year  = \App\Withdraw::where('status', 1)->whereYear('created_at', \Carbon\Carbon::now()->year)->sum('sum');
							$profit_year  = round($deps_year  - $withdraws_year ,2);

							@endphp
							<div class="col-lg-6"> 
								<span class="text-secondary text-admin-title">Профит</span>
								<span class="text-secondary text-admin-title" style="color: black;font-size:35px;margin-top: 10px;margin-bottom: 30px;display: block;">{{$profit}} ₽</span>
								<div class="progress_danger"><div class="prog_success" style="width:10%"></div></div>

								<div class="flex no_padding wrap">
									<div class="col-lg-5">
										<div class="flex no_padding">
											<div class="col"><span class="text-secondary text-admin-title">Пополнений всего</span></div>
											<div class="col col-3 text-right text-secondary text-admin-title">{{$deps}} ₽</div>
										</div>

										<div class="flex no_padding">
											<div class="col"><span class="text-secondary text-admin-title">Выводов всего</span></div>
											<div class="col col-3 text-right text-secondary text-admin-title">{{$withdraws}} ₽</div>
										</div>

										<div class="flex no_padding">
											<div class="col"><span class="text-secondary text-admin-title">Профит всего</span></div>
											<div class="col col-3 text-right text-secondary text-admin-title">{{$profit}} ₽</div>
										</div>

										<div class="hr"></div>

										<div class="flex no_padding">
											<div class="col"><span class="text-secondary text-admin-title">Пополнений за сегодня</span></div>
											<div class="col col-3 text-right text-secondary text-admin-title">{{$deps_today}} ₽</div>
										</div>

										<div class="flex no_padding">
											<div class="col"><span class="text-secondary text-admin-title">Выводов за сегодня</span></div>
											<div class="col col-3 text-right text-secondary text-admin-title">{{$withdraws_today}} ₽</div>
										</div>

										<div class="flex no_padding">
											<div class="col"><span class="text-secondary text-admin-title">Профит за сегодня</span></div>
											<div class="col col-3 text-right text-secondary text-admin-title">{{$profit_today}} ₽</div>
										</div>

										<div class="hr"></div>

										<div class="flex no_padding">
											<div class="col"><span class="text-secondary text-admin-title">Пополнений за вчера</span></div>
											<div class="col col-3 text-right text-secondary text-admin-title">{{$deps_yesterday}} ₽</div>
										</div>

										<div class="flex no_padding">
											<div class="col"><span class="text-secondary text-admin-title">Выводов за вчера</span></div>
											<div class="col col-3 text-right text-secondary text-admin-title">{{$withdraws_yesterday}} ₽</div>
										</div>

										<div class="flex no_padding">
											<div class="col"><span class="text-secondary text-admin-title">Профит за вчера</span></div>
											<div class="col col-3 text-right text-secondary text-admin-title">{{$profit_yesterday}} ₽</div>
										</div>

									</div>
									<div class="col-lg-5">
										<div class="flex no_padding">
											<div class="col"><span class="text-secondary text-admin-title">Пополнений за неделю</span></div>
											<div class="col col-3 text-right text-secondary text-admin-title">{{$deps_week}} ₽</div>
										</div>

										<div class="flex no_padding">
											<div class="col"><span class="text-secondary text-admin-title">Выводов за неделю</span></div>
											<div class="col col-3 text-right text-secondary text-admin-title">{{$withdraws_week}} ₽</div>
										</div>

										<div class="flex no_padding">
											<div class="col"><span class="text-secondary text-admin-title">Профит за неделю</span></div>
											<div class="col col-3 text-right text-secondary text-admin-title">{{$profit_week}} ₽</div>
										</div>


										<div class="hr"></div>


										<div class="flex no_padding">
											<div class="col"><span class="text-secondary text-admin-title">Пополнений за месяц</span></div>
											<div class="col col-3 text-right text-secondary text-admin-title">{{$deps_month}} ₽</div>
										</div>

										<div class="flex no_padding">
											<div class="col"><span class="text-secondary text-admin-title">Выводов за месяц</span></div>
											<div class="col col-3 text-right text-secondary text-admin-title">{{$withdraws_month}} ₽</div>
										</div>

										<div class="flex no_padding">
											<div class="col"><span class="text-secondary text-admin-title">Профит за месяц</span></div>
											<div class="col col-3 text-right text-secondary text-admin-title">{{$profit_month}} ₽</div>
										</div>


										<div class="hr"></div>

										<div class="flex no_padding">
											<div class="col"><span class="text-secondary text-admin-title">Пополнений за год</span></div>
											<div class="col col-3 text-right text-secondary text-admin-title">{{$deps_year}} ₽</div>
										</div>

										<div class="flex no_padding">
											<div class="col"><span class="text-secondary text-admin-title">Выводов за год</span></div>
											<div class="col col-3 text-right text-secondary text-admin-title">{{$withdraws_year}} ₽</div>
										</div>

										<div class="flex no_padding">
											<div class="col"><span class="text-secondary text-admin-title">Профит за год</span></div>
											<div class="col col-3 text-right text-secondary text-admin-title">{{$profit_year}} ₽</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-1_4">
								<canvas id="today-profit-chart" width="800" height="400"></canvas><br>
								<canvas id="yesterday-profit-chart" width="800" height="400"></canvas><br>
								<canvas id="week-profit-chart" width="800" height="400"></canvas><br>
								<canvas id="month-profit-chart" width="800" height="400"></canvas>
							</div>


						</div>
						
						

						
						
					</div>
				</div>
			</div>
		</div> 
	</div>
</div> 

<script type="text/javascript">
	new Chart(document.getElementById("today-profit-chart"), {
		type: 'line',
		data: {
			labels: ['00:00','01:00','02:00',1750,1800,1850,1900,1950,1999,2050],
			datasets: [{ 
				data: [0,114,106,106,107,111,133,221,783,2478],
				label: "Пополнения",
				borderColor: "#73ff4f",
				fill: false
			}, { 
				data: [0,350,411,502,635,809,947,1402,3700,5267],
				label: "Выводы",
				borderColor: "#ff523b",
				fill: false
			}, { 
				data: [0,170,178,190,203,276,408,547,675,734],
				label: "Профит",
				borderColor: "#3cba9f",
				fill: false
			} 
			]
		},
		options: {
			title: {
				display: true,
				text: 'Статистика за сегодня'
			}
		}
	});


	new Chart(document.getElementById("yesterday-profit-chart"), {
		type: 'line',
		data: {
			labels: ['00:00','01:00','02:00',1750,1800,1850,1900,1950,1999,2050],
			datasets: [{ 
				data: [0,114,106,106,107,111,133,221,783,2478],
				label: "Пополнения",
				borderColor: "#73ff4f",
				fill: false
			}, { 
				data: [0,350,411,502,635,809,947,1402,3700,5267],
				label: "Выводы",
				borderColor: "#ff523b",
				fill: false
			}, { 
				data: [0,170,178,190,203,276,408,547,675,734],
				label: "Профит",
				borderColor: "#3cba9f",
				fill: false
			}
			]
		},
		options: {
			title: {
				display: true,
				text: 'Статистика за вчерв'
			}
		}
	});


	new Chart(document.getElementById("week-profit-chart"), {
		type: 'line',
		data: {
			labels: ['00:00','01:00','02:00',1750,1800,1850,1900,1950,1999,2050],
			datasets: [{ 
				data: [0,114,106,106,107,111,133,221,783,2478],
				label: "Пополнения",
				borderColor: "#73ff4f",
				fill: false
			}, { 
				data: [0,350,411,502,635,809,947,1402,3700,5267],
				label: "Выводы",
				borderColor: "#ff523b",
				fill: false
			}, { 
				data: [0,170,178,190,203,276,408,547,675,734],
				label: "Профит",
				borderColor: "#3cba9f",
				fill: false
			}
			]
		},
		options: {
			title: {
				display: true,
				text: 'Статистика за неделю'
			}
		}
	});


	new Chart(document.getElementById("month-profit-chart"), {
		type: 'line',
		data: {
			labels: ['00:00','01:00','02:00',1750,1800,1850,1900,1950,1999,2050],
			datasets: [{ 
				data: [0,114,106,106,107,111,133,221,783,2478],
				label: "Пополнения",
				borderColor: "#73ff4f",
				fill: false
			}, { 
				data: [0,350,411,502,635,809,947,1402,3700,5267],
				label: "Выводы",
				borderColor: "#ff523b",
				fill: false
			}, { 
				data: [0,170,178,190,203,276,408,547,675,734],
				label: "Профит",
				borderColor: "#3cba9f",
				fill: false
			}
			]
		},
		options: {
			title: {
				display: true,
				text: 'Статистика за месяц'
			}
		}
	});
</script>