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


<center>
	<span class="text-secondary" style="font-size: 20px;font-weight: 600;">Загрузка...</span>
</center>

