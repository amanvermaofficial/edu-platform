<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Otp\SendOtpRequest;
use App\Http\Requests\Otp\VerifyOtpRequest;
use App\Models\Student;
use Exception;
use Illuminate\Validation\ValidationException;

class OtpLogController extends Controller
{
   protected $otpService;

   public function __construct(SmsOtpService $otpService){
      $this->otpService = $otpService
   }
   public function sendOtp(sendOtpRequest $request){
        try {
         $phone = $request->phone;
         $student = Student::firstOrCreate([
            'phone'=>$phone
         ]);

         $this->otpService->sendOtp($student);

         return $this->successResponse('OTP sent successfully');
        } catch (ValidationException $e) {
         return $this->validationErrorReaponse($e->errors());
        }catch(Exception $e){
         return $this->systemErrorResponse($e->getMessage());
        }
   }

   public function verifyOtp(VerifyOtpRequest $request){
      $phone = $request->phone;
      $otp = $request->otp;

      $student = Student::where('phone',$phone)->first();

      if(!$student){
         return $this->validationErrorResponse('Student not found',404);
      }

      $isValid = $this->otpService->verifyOtp($student,$otp);

      if($isValid){
         $success['token'] = $student->createToken('verifiedOtp')->plainTextToken;
         return $this->successResponse('OTP verified successfully!',$success);
      }else{
         return $this->validationErrorResponse('Invalid or expired OTP!');
      }
   }
}
