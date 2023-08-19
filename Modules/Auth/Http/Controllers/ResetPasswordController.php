<?php

namespace Modules\Auth\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Mail\EmailVerification;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Modules\Teacher\Entities\Teacher;


class ResetPasswordController extends Controller
{
    public function resetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return ApiResponse::sendResponse(422, 'Validation Errors', $validator->errors());
        }

        $email = $request->email;
        $teacher = Teacher::where('email', $email)->first();

        if ($teacher) {
            $registerController = new RegisterController();
            $registerController->otpGenerate($teacher);
            Mail::to($teacher->email)->send(new EmailVerification($teacher->otp, $teacher->name));

            return ApiResponse::sendResponse(200, 'OTP has been sent to your email.', []);
        }

        return ApiResponse::sendResponse(400, 'User not found', []);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8',
        ]);
        if ($validator->fails()) {
            return ApiResponse::sendResponse(422, 'Validation Errors', $validator->errors());
        }
        $currentTeacher = Auth::guard('teacher')->user();
        DB::table('teachers')
            ->where('id', $currentTeacher->id)
            ->update(['password' => bcrypt($request->password)]);

        return ApiResponse::sendResponse(201, 'Password updated Successfully', []);
    }

}
