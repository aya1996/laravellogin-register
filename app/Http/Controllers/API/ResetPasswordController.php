<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User as ModelsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'exists:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:8'],
        ],[
            "code.required"     => "حقل الكود مطلوب",
            "code.string"       => "يجب ان يكون الكود نص",
            "email.required"    => "حقل البريد مطلوب",
            "email.string"      => "يجب ان يكون البريد نص",
            "email.email"       => "يجب ان يكون البريد  إلكتروني صالح",
            "email.exists"      => "هذا البريد غير موجود",
        ]);

        if($validator->fails()) {
            return response()->json(["message" => $validator->errors()], 401);
        }
        $code = DB::table('password_resets')->where('email', $request->email)->first();
        if(!$code) {
            abort(404);
        }
        
        if(!Hash::check($request->code, $code->token)) {
            return response()->json(["message" => 'كود غير صحيح'], 401);
        }
        
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json(
            [
                "message" => 'تم تغيير كلمة المرور بنجاح'
            ],
            200
        );
}
}