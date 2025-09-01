<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Otp\SendOtpRequest;
use App\Http\Requests\Otp\VerifyOtpRequest;
use App\Models\Student;
use App\Services\Otp\SmsOtpService;
use Auth;
use Exception;
use Illuminate\Validation\ValidationException;
use PhpParser\Node\Stmt\TryCatch;

class OtpLogController extends Controller
{
   protected $otpService;

   public function __construct(SmsOtpService $otpService)
   {
      $this->otpService = $otpService;
   }
   public function sendOtp(sendOtpRequest $request)
   {
      try {
         $phone = $request->phone;
         $student = Student::firstOrCreate([
            'phone' => $phone
         ]);

         $this->otpService->sendOtp($student);

         return $this->successResponse('OTP sent successfully');
      } catch (ValidationException $e) {
         return $this->validationErrorReaponse($e->errors());
      } catch (Exception $e) {
         return $this->systemErrorResponse($e->getMessage());
      }
   }

   public function verifyOtp(VerifyOtpRequest $request)
   {
      $phone = $request->phone;
      $otp = $request->otp;

      $student = Student::where('phone', $phone)->first();

      if (!$student) {
         return $this->validationErrorResponse('Student not found', 404);
      }

      $isValid = $this->otpService->verifyOtp($student, $otp);

      if ($isValid) {
         if (is_null($student->mobile_verified_at)) {
            $student->mobile_verified_at = now();
            $student->save();
         }

         $this->otpService->deleteOtp($student);

         Auth::guard('student')->login($student);

         return $this->successResponse('OTP verified successfully!', [
            'token' => $student->createToken('verifiedOtp')->plainTextToken,
            'redirect' => $student->completed_profile ? '/dashboard' : '/complete-profile'
         ]);
      }
      return $this->validationErrorResponse('Invalid or expired OTP!');
   }

   public function logout(Request $request)
   {
      try{
         $result = $this->otpService->logout($request);
         return response()->json([
            'status' => $result['status'],
            'message' => $result['message']
         ],$result['code']);
      }catch(Exception $e){
         return $this->systemErrorResponse($e->getMessage());
      }
      
   }
}
