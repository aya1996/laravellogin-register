<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;

class CheckCodeController extends Controller
{
    public function checkCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'exists:users,email']
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
        

        return response()->json(
            [
                "message" => 'تم التحقق من الكود بنجاح'
            ],
            200
        );
    }
}
