<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Slots;
use App\User;
use Auth;
use App\Payment;
use Illuminate\Support\Facades\File;

class SlotsControllerNew extends Controller
{
    public function getGames()
    {
        $jsonContent = File::get(__DIR__.'/b_games_all.json');
        $games = json_decode($jsonContent);
    
        return response()->json($games);
    }

    public function getGameURI(Request $request)
    {
        $user = User::where('id', Auth::id())->first();

        if(!$user) {
            return ['error' => 'Log in or register!'];
        }

        $apiKey = env('MORTALSOFT_KEY');

        $api = 'https://api-prod.mortalsoft.online/api/'.$apiKey.'/createSession?identifier='.$user->id.'&balance='.$user->balance;
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $api);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        $curl_data = curl_exec($curl_handle);
        curl_close($curl_handle);

        $response = json_decode($curl_data, true);
        $token = $response['original']['token'];

        $url = "https://api-prod.mortalsoft.online/play/".$request->id."/".$token;

        return [
            'url' => $url,
            'image' => "https://api-prod.mortalsoft.online/i/".$request->id.".jpg",
            'name' => $request->id
        ];
    }

    public function callback(Request $request)
    {
        $newBalance = $request->input('new_balance');
        $oldBalance = $request->input('old_balance');
        $user = $request->input('identifier');
        $key = $request->input('token');
        $this->writeBet($newBalance, $user, $key);
    }
    
    public function getBalance($login)
    {
        if ($login) {
            $user = User::lockForUpdate()->where('id', $login)->first();
            return [
                "status"   => "success",
                "error"    => "",
                "login"    => $login,
                "balance"  => number_format($user->balance, 2, '.', ''),
                "currency" => "DLS"
            ];
        } else {
            \Log::info($login);
        }
    }
    
    public function writeBet($newBalance, $userid, $key)
    {
        $user = User::where('id', $userid)->first();
    
        if (!$user) {
            return [
                'status' => 'fail',
                'error'  => 'user_not_found'
            ];
        }
    
        $user->balance = $newBalance;
        $user->save();
    
        return [
            "status"      => "success",
            "error"       => "",
            "login"       => $user->id,
            "balance"     => number_format($user->balance, 2, '.', ''),
            "currency"    => "DLS",
            "operationId" => time()
        ];
    }
    

    private function trxCancel($data) {
        return response()->json(['status' => 200]);
    }

    private function trxComplete($data) {
        return response()->json(['status' => 200]);
    }

    private function checkSession($data) {
        if(!$data->session) return response()->json(['status' => 404, 'method' => 'check.session', 'message' => 'Unknown session']);
        $user = User::where('api_token', $data->session)->first();
        if(!$user) return response()->json(['status' => 404, 'method' => 'check.session', 'message' => 'Unknown user']);

        return response()->json(['status' => 200, 'method' => 'check.session', 'response' => ['id_player' => $user->id, 'id_group' => 'default', 'balance' => round($user->type_balance == 0 ? $user->balance * 100 : $user->demo_balance * 100)]]);
    }

    private function checkBalance($data) {
        if(!$data->session) return response()->json(['status' => 404, 'method' => 'check.balance', 'message' => 'Unknown session']);
        $user = User::where('api_token', $data->session)->first();
        if(!$user) return response()->json(['status' => 404, 'method' => 'check.balance', 'message' => 'Unknown user']);

        return response()->json(['status' => 200, 'method' => 'check.balance', 'response' => ['currency' => 'RUB', 'balance' => round($user->type_balance == 0 ? $user->balance * 100 : $user->demo_balance * 100)]]);
    }

    public function userBet($data) {
        if(!$data->session) return response()->json(['status' => 404, 'method' => 'withdraw.bet', 'message' => 'Unknown session']);
        $user = User::where('api_token', $data->session)->first();
        if(!$user) return response()->json(['status' => 404, 'method' => 'withdraw.bet', 'message' => 'Unknown user']);

        if($user->type_balance == 0) {
            if($user->balance < ($data->amount / 100)) return response()->json(['status' => 404, 'method' => 'withdraw.bet', 'message' => 'Fail balance']);
        } else {
            if($user->demo_balance < ($data->amount / 100)) return response()->json(['status' => 404, 'method' => 'withdraw.bet', 'message' => 'Fail balance']);
        }

        $wager = ($user->sum_to_withdraw - $data->amount / 100) < 0 ? 0 : $user->sum_to_withdraw - $data->amount / 100;

        if($user->type_balance == 0) {
            $user->balance -= $data->amount / 100;
            $user->sum_to_withdraw = $wager;
        } else {
            $user->demo_balance -= $data->amount / 100;
        }
        $user->save();

        return response()->json(['status' => 200, 'method' => 'withdraw.bet', 'response' => ['currency' => 'RUB', 'balance' => round($user->type_balance == 0 ? $user->balance * 100 : $user->demo_balance * 100)]]);
    }

    public function userWin($data) {
        if(!$data->session) return response()->json(['status' => 404, 'method' => 'deposit.win', 'message' => 'Unknown session']);
        $user = User::where('api_token', $data->session)->first();
        if(!$user) return response()->json(['status' => 404, 'method' => 'deposit.win', 'message' => 'Unknown user']);

        if($user->type_balance == 0) {
            $user->balance += $data->amount / 100;
        } else {
            $user->demo_balance += $data->amount / 100;
        }
        $user->save();

        return response()->json(['status' => 200, 'method' => 'deposit.win', 'response' => ['currency' => 'RUB', 'balance' => round($user->type_balance == 0 ? $user->balance * 100  : $user->demo_balance * 100)]]);
    }
}
