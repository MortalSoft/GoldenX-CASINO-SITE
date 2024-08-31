<?php 

namespace App\Service;
use App\User;
use App\Authorization;
use Request;
use Illuminate\Support\Facades\Hash;
class SocialService{
	public function saveSocialData($user, $social, $type){
		$social_id = $user->getId();
		$email = $user->getEmail();
		$name = $user->getName();
		$avatar = $user->getAvatar() ?? 'https://ustanovkaos.ru/wp-content/uploads/2022/02/06-psevdo-pustaya-ava.jpg';

		$social = $social.''.$social_id;
		$ip = (isset($_SERVER["HTTP_CF_CONNECTING_IP"])?$_SERVER["HTTP_CF_CONNECTING_IP"]:$_SERVER['REMOTE_ADDR']);
		$ref = 0;
		$ref_id = session('ref_id');
		if ($ref_id > 0){
			$ref = $ref_id;

		}

		$vk_id = Null;
		$tg_id = Null;

		if($type == 'vk'){
			$vk_id = $social_id;
		}

		if($type == 'tg'){
			$tg_id = $social_id;
		}

		$data =  ['ref_id' => $ref,'ip' => $ip,'email' => $email, 'social_id' => $social_id, 'name' => $name, 'avatar' => $avatar, 'social' => $social, 'vk_id' => $vk_id, 'tg_id' => $tg_id];
		
		$u = User::where('social_id', $social_id)->first();
		if($u){
			
			
			// User::where('vk_id', $vk_id)->update(['ip' => $ip,'social' => $social,'name' => $name, 'avatar' => $avatar]);
			
		
			return $u;	
		}else{

			if($ref > 0){
				$count_r = User::where('id', $ref_id)->get();
				if(count($count_r) > 0){
					$refs = $count_r[0]->refs + 1;        
					$bonus_refs = $count_r[0]->bonus_refs + 1; 
					User::where('id', $ref_id)->update(['refs' => $refs, 'bonus_refs' => $bonus_refs]); 
				}
			}
		}


		
		return  User::create($data);
		
	}
}
?>