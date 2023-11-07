<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use App\Models\PasswordReset;
use App\Services\MailService;
use App\Models\User;

use Validator;
use Carbon\Carbon;



class PasswordResetController extends Controller
{

    public function __construct(PasswordReset $passwordReset, MailService $mailService, User $user)
    {
        $this->passwordResetModel = $passwordReset;
        $this->mailService = $mailService;
        $this->userModel = $user;

    }

    public function forgot(Request $request)
    {   
        request()->validate([
                'email'      =>  'required'
        ]);

        $user = $this->userModel->where('email', $request->email)->first();

        if (!@$user) {
            sleep(rand(1,3));
            $response = ['status' => true, 'message' => 'Foi enviado um email de recuperação de senha'];
            return $response;
        }
        $hash = $this->createHash($request->email);

        $arrayBody = array(
            'name' => $user->name, 
            'hash' => $hash,
            'email' => $request->email,
            'url' => env('APP_ENV') != 'PROD' ? 'https://app-dev.diag.app.br/password/reset?token' : 'https://app.diag.app.br/password/reset?token'
        );

        $mail = null;

        if ($hash) {
            $body = view('emails.reset', $arrayBody)->render();
            $mail = $this->mailService->sendMail('Redefinir senha', $body, $request->email, @$user->name);
        }

        return ['status' => true, 'message' => 'Foi enviado um email de recuperação de senha'];
        
    }

    public function createHash($email)
    {   
        $str = ['(', ')', '.', '-','?','/'];
        $rplc =['','','','','',''];

        $randonToken = Str::random(20);

        $hash = Hash::make($randonToken.$email);
        $stringClean = str_replace($str,$rplc,$hash);

        $p = PasswordReset::firstOrNew(
            ['email' => $email]
        );

        $p->token = $stringClean;
        $p->created_at = date('Y-m-d H:i:s');

        $p->save();

        return $stringClean;
    }
    
    public function existToken($email)
    {
        return PasswordReset::where('email', $email)->exist();
    }

    public function validToken($token, $email)
    {
        $token = urldecode($token);
        $token = PasswordReset::where('token', $token)->where('email', $email)->first();
        if(!$token){
            return false;
        }
        $date = Carbon::parse(@$token->created_at);
        $now = Carbon::now();
        $days = $date->diffInDays($now);

        if ($days >= 1) {
            return false;
        }else{
            $token->delete();
            return true;
        }
    }

    public function reset(Request $request)
    {

        request()->validate([
            'email'      =>  'required',
            'token'      =>  'required',
            'password'      =>  'required'
        ]);

        if (!$this->validToken($request->token, $request->email)){
            $response = ['status' => false, 'message' => 'Token inválido'];
            return $response;
        }
        $user = $this->userModel->where('email', $request->email)->first();
        $user->password = bcrypt($request->password);
        $user->save();

        $response = ['status' => true, 'message' => 'Senha alterada com sucesso'];
        return $response;
    }




}
