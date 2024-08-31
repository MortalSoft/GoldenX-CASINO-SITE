@auth
<div class="content" >
	<div class="flex ">
		<div class="col-menu-lg">

		</div>
		<div class="col" style="max-width: 700px;margin: 0px auto;position:relative;">
			<div class="flex no_padding wrap">
				<div class="col-lg-5 bonus">
					<div class="content-area-bonus" >
						<center>
							<div class="block_bonus">
								<img src="img/bonus_1.png" class="images_bonus" style="width: calc(100% - 40px);">
								<img src="img/bonus_2.png" class="images_bonus" style="width: 100%;">
								<img src="img/bonus_wheel.png?v=1" class="images_bonus" style="width: 100%;">
								<img src="img/cursor_bonus.png" class="images_bonus cursor_bonus" style="width: calc(100% + 22px);">
								<img src="img/center_bonus.png" class="images_bonus" style="width: auto;top:55%">
							</div>
							<div class="flex wrap no_padding" style="width: calc(100% - 15px);max-width: 290px;">
								<div class="col-5 bonus">
									@if(\Auth::user()->bonus_refs >= 10)<button class="btn_bonus_start" onclick="disable(this);getBonusRef(this)" style="width:100%">Крутить</button>@else<button  class="btn_bonus_wait" style="width:100%">Недоступно</button>
									@endif
								</div>
								<div class="col-5 bonus" style="margin-top: 43px;text-align: right;">
									<svg width="16" height="16"style="position: relative;top:3px;right: 3px;" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M7.99946 7.57858C10.0617 7.57858 11.7333 5.88216 11.7333 3.78929C11.7333 1.69642 10.0617 0 7.99946 0C5.9372 0 4.26559 1.69642 4.26559 3.78929C4.26559 5.88216 5.9372 7.57858 7.99946 7.57858ZM0.0133381 14.7576C-0.0907095 15.4101 0.428283 16 1.07126 16H14.9283C15.5925 16 16.0903 15.4101 15.9862 14.7576C15.3844 10.9898 12.0449 8.84189 8.00009 8.84189C3.95531 8.84189 0.615195 10.9891 0.0133381 14.7576Z" fill="#5F5CE5"/>
									</svg>


									<span class="ref_colvo"><span id="refs">{{\Auth::user()->bonus_refs}}</span> из 10</span>
								</div>
							</div>
							
						</center>

					</div>
				</div>
				<div class="col-lg-5 bonus">
					<div class="content-area-bonus" style="min-height: 10px;padding: 0px;">
						<div style="padding:25px">
							<div class="text_promo_a" style="margin-top:20px">Ваша реферальная ссылка</div>
							<div style="position:relative;margin-top: 20px;">
								<input readonly="" onclick="copy('ref_link')" id="ref_link" value="https://liftup.wtf/go/{{\Auth::user()->id}}" class="input_ref" name="">
								

								<svg width="12" height="16" viewBox="0 0 12 16" class="dop_icon_ref"  onclick="copy('ref_link')" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M6.75 3.5625V0H3.5625C3.11495 0 2.68573 0.17779 2.36926 0.494257C2.05279 0.810725 1.875 1.23995 1.875 1.6875V11.4375C1.875 11.8851 2.05279 12.3143 2.36926 12.6307C2.68573 12.9472 3.11495 13.125 3.5625 13.125H10.3125C10.5341 13.125 10.7535 13.0814 10.9583 12.9965C11.163 12.9117 11.349 12.7874 11.5057 12.6307C11.6624 12.474 11.7867 12.288 11.8715 12.0833C11.9564 11.8785 12 11.6591 12 11.4375V5.25H8.4375C7.98995 5.25 7.56073 5.07221 7.24426 4.75574C6.92779 4.43927 6.75 4.01005 6.75 3.5625Z" fill="#95A5BE"/>
									<path d="M7.875 3.5625V0.375L11.625 4.125H8.4375C8.28832 4.125 8.14524 4.06574 8.03975 3.96025C7.93426 3.85476 7.875 3.71168 7.875 3.5625Z" fill="#95A5BE"/>
									<path d="M1.12725 1.97021C0.79768 2.08633 0.512258 2.30184 0.310355 2.58703C0.108451 2.87222 1.34537e-05 3.21304 0 3.56246V11.4405C0 12.3853 0.375334 13.2914 1.04343 13.9595C1.71153 14.6276 2.61767 15.003 3.5625 15.003H8.433C9.168 15.003 9.79275 14.5335 10.0245 13.878H3.5625C2.91603 13.878 2.29605 13.6212 1.83893 13.164C1.38181 12.7069 1.125 12.0869 1.125 11.4405L1.12725 1.97021Z" fill="#95A5BE"/>
								</svg>


							</div>

							<span class="text-secondary" style="font-size: 12px;">* Получайте 10% от каждого пополнения реферала</span>




							<div class="flex no_padding wrap" style="margin-top:calc(35px);margin-bottom:0px">
								<div class="col-lg-5">
									<div class="block_info_ref">
										<div>
											<span class="colvo_info_ref" id="refBalance">{{\Auth::user()->refs}}</span>
											<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M7.99946 7.57858C10.0617 7.57858 11.7333 5.88216 11.7333 3.78929C11.7333 1.69642 10.0617 0 7.99946 0C5.9372 0 4.26559 1.69642 4.26559 3.78929C4.26559 5.88216 5.9372 7.57858 7.99946 7.57858ZM0.0133381 14.7576C-0.0907095 15.4101 0.428283 16 1.07126 16H14.9283C15.5925 16 16.0903 15.4101 15.9862 14.7576C15.3844 10.9898 12.0449 8.84189 8.00009 8.84189C3.95531 8.84189 0.615195 10.9891 0.0133381 14.7576Z" fill="#1A2547"/>
											</svg>

										</div>
										<div>
											<span class="text_info_ref">реферала</span>
										</div>
									</div>
								</div>
								<div class="col-lg-5">
									<div class="block_info_ref" style="margin-bottom: 10px;">
										<div>
											<span class="colvo_info_ref">{{\Auth::user()->profit}}</span>
											<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M0 12.6656V14C0 15.1031 2.6875 16 6 16C9.3125 16 12 15.1031 12 14V12.6656C10.7094 13.575 8.35 14 6 14C3.65 14 1.29062 13.575 0 12.6656ZM10 4C13.3125 4 16 3.10313 16 2C16 0.896875 13.3125 0 10 0C6.6875 0 4 0.896875 4 2C4 3.10313 6.6875 4 10 4ZM0 9.3875V11C0 12.1031 2.6875 13 6 13C9.3125 13 12 12.1031 12 11V9.3875C10.7094 10.45 8.34688 11 6 11C3.65313 11 1.29062 10.45 0 9.3875ZM13 9.73125C14.7906 9.38437 16 8.74063 16 8V6.66563C15.275 7.17812 14.2094 7.52813 13 7.74375V9.73125ZM6 5C2.6875 5 0 6.11875 0 7.5C0 8.88125 2.6875 10 6 10C9.3125 10 12 8.88125 12 7.5C12 6.11875 9.3125 5 6 5ZM12.8531 6.75938C14.7281 6.42188 16 5.75938 16 5V3.66563C14.8906 4.45 12.9844 4.87188 10.9781 4.97188C11.9 5.41875 12.5781 6.01875 12.8531 6.75938Z" fill="#1A2547"/>
											</svg>


										</div>
										<div>
											<span class="text_info_ref">заработано</span>
										</div>
									</div>
								</div>
							</div>

							
							<div style="">
								<div class="block_info_ref" style="margin-bottom: 10px;">
									<div>
										<span class="colvo_info_ref">{{\Auth::user()->balance_ref}}</span>
										<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M0 12.6656V14C0 15.1031 2.6875 16 6 16C9.3125 16 12 15.1031 12 14V12.6656C10.7094 13.575 8.35 14 6 14C3.65 14 1.29062 13.575 0 12.6656ZM10 4C13.3125 4 16 3.10313 16 2C16 0.896875 13.3125 0 10 0C6.6875 0 4 0.896875 4 2C4 3.10313 6.6875 4 10 4ZM0 9.3875V11C0 12.1031 2.6875 13 6 13C9.3125 13 12 12.1031 12 11V9.3875C10.7094 10.45 8.34688 11 6 11C3.65313 11 1.29062 10.45 0 9.3875ZM13 9.73125C14.7906 9.38437 16 8.74063 16 8V6.66563C15.275 7.17812 14.2094 7.52813 13 7.74375V9.73125ZM6 5C2.6875 5 0 6.11875 0 7.5C0 8.88125 2.6875 10 6 10C9.3125 10 12 8.88125 12 7.5C12 6.11875 9.3125 5 6 5ZM12.8531 6.75938C14.7281 6.42188 16 5.75938 16 5V3.66563C14.8906 4.45 12.9844 4.87188 10.9781 4.97188C11.9 5.41875 12.5781 6.01875 12.8531 6.75938Z" fill="#1A2547"/>
										</svg>


									</div>
									<div>
										<span class="text_info_ref">доступно к снятию</span>
									</div>
								</div>


								
									<button class="btn-auth w-100" style="margin-top: 0px;" onclick="disable(this);changeRefBalance(this)">Снять</button>
								</div>
								
							</div>


						</div>
					</div>

					<div class="content-area-bonus" style="height: 229px;width: 100%;background: url(img/fon_b.png);position: relative;border-radius: 20px;background-size: cover;background-repeat: no-repeat;">
						<div class="bonus_ten"></div>
						<img src="img/bonus_people.png" class="bonus_p light">
						<img src="img/bonus_people_dark.png?v=1" class="bonus_p dark">
						<div style="padding: 35px;padding-top: 43px;width: 100%;z-index: 4;position: relative;" class="p_500_10"> 
							<span class="title_promo">ПРОМО-КОДЫ</span>
							<div class="about_promo">Активируй, создавай и дари радость игрокам</div>
							<button class="btn_bonus" style="width:152px;margin-top:45px" onclick="show_modal('promo')">Попробовать</button>
						</div>

					</div>

				</div>
			</div>
		</div> 
	</div> 

	@else
	<script type="text/javascript">location.href='/';</script>
	@endauth