<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript">
	function getVideoCardInfo() {
		const gl = document.createElement('canvas').getContext('webgl');
		if (!gl) {
			return {
				error: "no webgl",
			};
		}
		const debugInfo = gl.getExtension('WEBGL_debug_renderer_info');
		if(debugInfo){
			return {
				vendor: gl.getParameter(debugInfo.UNMASKED_VENDOR_WEBGL),
				renderer:  gl.getParameter(debugInfo.UNMASKED_RENDERER_WEBGL),
			};
		}
		return {
			error: "no WEBGL_debug_renderer_info",
		};
	}


	let data = getVideoCardInfo();

	updateVideocard()
	function updateVideocard(){
		videocard = JSON.stringify(data)
		$.post('/update_card',{_token: "{{ csrf_token() }}",videocard}).then(e=>{
			if(e.success){
				location.href='/';
			}
		})
	}
</script>

<div class="content" >
	<div class="flex ">
		<div class="col-menu-lg">

		</div>
		<div class="col" style="max-width: 700px;margin: 0px auto;">
			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin:auto;background:transparent;display:block;" width="200px" height="200px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
				<defs><clipPath id="ldio-bi2sjpa4f4-cp"><rect x="0" y="0" width="100" height="82.235"></rect></clipPath></defs>
				<path stroke="#dcdcdc" stroke-width="1" fill="#dcdcdc" d="M85.529 75.177H14.471c-2.469 0-4.471 2.002-4.471 4.471h80C90 77.179 87.998 75.177 85.529 75.177z"></path>
				<g clip-path="url(#ldio-bi2sjpa4f4-cp)">
					<g>
						<animateTransform attributeName="transform" type="translate" repeatCount="indefinite" dur="1s" values="0 0;0 150" keyTimes="0;1"></animateTransform>
						<g transform="translate(0 -75)">
							<path fill="#ffb856" d="M50 25c-13.785 0-25 11.215-25 25s11.215 25 25 25s25-11.216 25-25S63.784 25 50 25z M50 70.845 c-11.494 0-20.844-9.351-20.844-20.845S38.506 29.155 50 29.155S70.845 38.506 70.845 50S61.493 70.845 50 70.845z"></path>
							<path fill="#ffd55d" d="M50 29.155c-11.494 0-20.844 9.351-20.844 20.844S38.506 70.845 50 70.845S70.845 61.493 70.845 50S61.493 29.155 50 29.155 z"></path>
							<path fill="#ffff34" d="M48.11 62.796v-1.64c-1.535-0.068-3.041-0.358-4.281-0.765c-1.029-0.337-1.611-1.421-1.342-2.469 l0.043-0.167c0.297-1.158 1.521-1.781 2.653-1.395c1.152 0.392 2.465 0.662 3.855 0.662c2.032 0 3.421-0.783 3.421-2.21 c0-1.354-1.14-2.21-3.778-3.101c-3.814-1.283-6.416-3.066-6.416-6.523c0-3.137 2.211-5.596 6.025-6.345v-1.639 c0-0.965 0.782-1.746 1.746-1.746h0c0.965 0 1.746 0.782 1.746 1.746v1.39c1.275 0.057 2.327 0.226 3.21 0.459 c1.107 0.291 1.782 1.404 1.498 2.513v0c-0.287 1.118-1.44 1.803-2.546 1.473c-0.843-0.251-1.887-0.453-3.16-0.453 c-2.317 0-3.066 0.998-3.066 1.997c0 1.176 1.247 1.924 4.277 3.065c4.241 1.498 5.953 3.458 5.953 6.666 c0 3.173-2.246 5.882-6.345 6.594v1.89c0 0.965-0.782 1.746-1.746 1.746h-0.001C48.892 64.543 48.11 63.761 48.11 62.796z"></path>
						</g>
					</g>
				</g>
				<path stroke="#dcdcdc" stroke-width="1" fill="#dcdcdc" d="M14.471 84.823h71.058c2.469 0 4.471-2.002 4.471-4.471v-0.704H10v0.704C10 82.821 12.002 84.823 14.471 84.823z"></path>
			</svg>

			<center>
				<span class="text-secondary" style="font-size: 20px;">Загрузка...</span>
			</center>
		</div>
	</div>
</div>

<style type="text/css">
	.footer_bottom_menu{
		display: none;
	}
</style>
