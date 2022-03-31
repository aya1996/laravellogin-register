<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Notifications\ResetPasswordLink;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string']
        ],[
            "email.required"     => "حقل البريد مطلوب",
            "email.string"       => "يجب ان يكون البريد نص",
        ]);

        if($validator->fails()) {
            return response()->json(["message" => $validator->errors()], 401);
        }

        $user = User::where('email', $request->email)->first();

        if(!$user) {
            return response()->json(["message" => 'هذا البريد غير موجود'], 401);
        }

        $check = DB::table('password_resets')->where('email', $request->email)->first();
        if($check) {
            return response()->json(["message" => 'لقد تم إرسال رابط تغيير كلمة المرور بالبريد الإلكتروني سابقا'], 401);
        }
        $code = rand(100000, 999999);
        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => bcrypt($code),
        ]);
        $user->notify(new ResetPasswordLink($code));
        return response()->json(
            [
                "message" => 'تم ارسال رسالة عبر البريد بها لينك إعادة تعيين كلمة السر'
            ],
            200
        );
    }
}
