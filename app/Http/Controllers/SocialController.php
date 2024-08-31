<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
class SocialController extends Controller
{
	public function index(){
		return Socialite::driver('vkontakte')->redirect();
	}

	public function callback(){
		$user = Socialite::driver('vkontakte')->user();
		$objSocial = new \App\Service\SocialService(); 
		if ($user = $objSocial->saveSocialData($user, 'https://vk.com/id', 'vk')){
			\Auth::login($user);
			return redirect('/');
		}

		return back(400);
	}

	public function tg_index(){
		return Socialite::driver('telegram')->redirect();
	}

	public function tg_callback(){
		$user = Socialite::driver('telegram')->user();
		$objSocial = new \App\Service\SocialService(); 
		if ($user = $objSocial->saveSocialData($user, 'https://t.me/', 'tg')){
			\Auth::login($user);
			return redirect('/');
		}

		return back(400);
	}

	public function yandex_index(){
		return Socialite::driver('yandex')->redirect();
	}

	public function yandex_callback(){
		$user = Socialite::driver('yandex')->user();
		$objSocial = new \App\Service\SocialService(); 
		if ($user = $objSocial->saveSocialData($user, 'https://yandex.ru/', '')){
			\Auth::login($user);
			return redirect('/');
		}

		return back(400);
	}

	public function google_index(){
		return Socialite::driver('google')->redirect();
	}

	public function google_callback(){
		$user = Socialite::driver('google')->user();
		$objSocial = new \App\Service\SocialService(); 
		if ($user = $objSocial->saveSocialData($user, 'https://google.com/', '')){
			\Auth::login($user);
			return redirect('/');
		}

		return back(400);
	}

}
