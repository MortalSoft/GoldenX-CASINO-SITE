@php
$systemDeps = \App\SystemDep::where('off', 0)->get();
@endphp

@foreach($systemDeps as $s)
<style type="text/css">	
	.wallet__method--active.wallet__method--{{$s->id}}_DEPOSIT {
		border-left: solid 3px {{$s->color}};
	}
</style>
@endforeach

@php
$SystemWithraws = \App\SystemWithdraw::all();
@endphp

@foreach($SystemWithraws as $s)
<style type="text/css">	
	.wallet__method--active.wallet__method--{{$s->name}}_WITHDRAW {
		border-left: solid 3px {{$s->color}};
	}
</style>
@endforeach

<style type="text/css">	

	.wallet__method--active.wallet__method--Qiwi {
		border-left: solid 3px #FF994F;
	}

	.wallet__method--active.wallet__method--Piastrix {
		border-left: solid 3px #FF4182;
	}

	.wallet__method--active.wallet__method--VISA{
		border-left: solid 3px #313d86;
	}

	.wallet__method--active.wallet__method--MCARD {
		border-left: solid 3px #eb041e;
	}

	.wallet__method--active.wallet__method--FreeKassa {
		border-left: solid 3px #a11c5a;
	}

	.wallet__method--active.wallet__method--VkPay {
		border-left: solid 3px #4c75a3;
	}

	.wallet__method--active.wallet__method--FkWallet {
		border-left: solid 3px #146fff;
	}
</style>