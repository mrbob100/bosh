<?php

namespace App\Http\Controllers;
use App\User;
use  Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserResource;
use Response;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $user=User::where('email',$request->email)->where('name', $request->name)->first();
        $sd= bcrypt($request->password);
        if(empty($user)) {
            $v = Validator::make($request->all(), [
                'email' => 'required|email|unique:users',
                'password' => 'required|min:3',
                'name' => 'required| max:255',
                'phone' => 'required|min:7| max:14'
            ]);
            if ($v->fails()) {
                return response()->json([
                    'status' => 'Ошибка регистрации, проверьте введенные данные !',
                    'errors' => $v->errors()
                ], 422);
            }


        $user = new User;
        $user->email = $request->email;
        $user->phone= $request->phone;
        $user->name=$request->name;
        $user->role_id=1;
        $user->password = bcrypt($request->password);
            $user->save();
        }

        if(!$token = auth()->attempt($request->only(['email', 'password'])))

        {
            return abort(401);
        }
     $as=$user;
     /*  return (new UserResource($user))
            ->additional([
                'meta' => [
                    'api_token' => $token
                ]
            ]); */


        return response()->json(['status' => true,
            'role_id'=>$user->role_id,
            'token' => $token,
            'user_id'=>$user->id
        ],
            200);


    }


    public function login(Request $request)
    {


        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        if(!$token = auth()->attempt($request->only(['email', 'password'])))
        {
            return response()->json([
                'errors' => [
                    'email' => ['There is something wrong! We could not verify details']
                ]], 422);
        }
        $user=User::where('email',$request->email)->first();
        if($user)
        {
            if(password_verify($request->password, $user->password))
            {
                return  response()->json([
                    'status'=>true,
                    'api_token'=>$token,
                    'user_id'=>$user->id,
                    'role_id'=>$user->role_id

                ]);
            }
        }
    }



    public function logout()
    {
        $this->guard()->logout();
        return response()->json([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }


    public function user(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }
    public function refresh()
    {
        if ($token = $this->guard()->refresh()) {
            return response()
                ->json(['status' => 'success'], 200)
                ->header('Authorization', $token);
        }
        return response()->json(['error' => 'refresh_token_error'], 401);
    }
    private function guard()
    {
        return Auth::guard();
    }
}
