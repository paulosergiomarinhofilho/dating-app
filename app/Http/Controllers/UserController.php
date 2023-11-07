<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Like;
use App\Models\Dislike;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

use Carbon\Carbon;



class UserController extends Controller
{

    public function __construct()
    {
       
    }


    public function index(Request $request)
    {
        $users = User::latest();

        if ($request->q) {
            $users->where(function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->q}%")
                ->orWhere('crm', 'like', "%{$request->q}%")
                ->orWhere('email', 'like', "%{$request->q}%");
            });
        }

        if ($request->email) {
            $users->where('email', $request->email);
        }
  
        $list = 'desc';
        $orderBy =  'created_at';

        $users->orderBy($orderBy, $list);
        $users = $users->paginate(100)->toArray();

        $users['status'] = true;

        return $users;
    }


    public function cards(Request $request)
    {
        $user = $request->user();

        // Pegar as infos do user request
        $my_gender = $user->show_as_gender;
        $target_gender = $user->show_as_gender; // Gênero desejado
        $minAge = $user->age_min; // Idade mínima
        $maxAge = $user->age_max;  // Idade máxima
        $birthdate = $user->birthdate; // Data de nascimento do usuário que busca

        $likes = Like::where('user_id', $user->id)->pluck('target_id')->toArray();;
        $dislikes = Dislike::where('user_id', $user->id)->pluck('target_id')->toArray();;
        $manualExclusions = [$user->id]; // Substitua pelos IDs manuais que você deseja excluir

        $excludeUserIds = array_merge($likes, $dislikes, $manualExclusions);

        $users = User::select();

        if ($minAge) {
            $users->where('birthdate', '<=', Carbon::now()->subYears($minAge)->toDateString());
        }
        if ($maxAge) {
            $users->where('birthdate', '>=', Carbon::now()->subYears($maxAge + 1)->toDateString());
        }
        $users->whereNotIn('id', $excludeUserIds); // Exclua os usuários com base nos IDs na array
        $users->where('show_as_gender', $target_gender);
        
        $users->where(function($query) use ($my_gender) {
            $query->where('target_gender', $my_gender)
                ->orWhere('target_gender', 'all');
        });

        $users->inRandomOrder();
        $users = $users->paginate(100)->toArray();

        return $users;    
    }

    public function store(StoreUserRequest $request)
    { 
        
        $dataUser = $request->validated();
        $dataUser['password'] = bcrypt($request->password);
        $user =  User::create($dataUser);
        $accessToken = $user->createToken('authToken')->plainTextToken;


        //if($user){
            //$this->welcomeEmail($user);
        //}
        //return UserResource::make($user);

        //add notification settings
        //$this->addDefaultNotificationSettings($user);

        return ['status' => true, 'data' => $user, 'access_token' => $accessToken];

    }

    public function show(User $user, Request $request)
    {   
        // if($request->patients)
        // {
        //     $user->load('patients');
        // }

        return ['status' => true, 'data' => $user];
    }

    public function update(UpdateUserRequest $request, User $user)
    {   
  
        $this->authorize('update', $user);

        $user->update($request->validated());

        

        if ($request->exists('active')){
            $user->active =  $request->active;

            if(!$request->active){
                $user->tokens()->where('tokenable_id', $user->id)->delete();
                $this->accountDisabledEmail($user);
            }
        }

        if ($request->password) {
            if (password_verify($request->old_password, $user->password)) {

                $user->password = bcrypt($request->password);
            }else{
                $response = ['status' => false, 'message' => 'Senha incorreta'];
                return $response;
            }
        }

        $user->save();

        return ['status' => true, 'data' => $user];
    }


    public function destroy(Request $request, User $user)
    {
        //$this->authorize('ownerOrAdmin', User::class);

        $user->tokens()->where('tokenable_id', $user->id)->delete();
        $user->delete();
        return ['status' => true, 'data' => $user];

    }

    public function registeredEmail(Request $request)
    {
        $exist = User::registeredEmail($request->email);
        return ['status' => true, 'registered' => $exist];
    }
}
