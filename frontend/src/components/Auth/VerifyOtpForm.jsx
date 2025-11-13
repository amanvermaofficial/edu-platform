import React from "react";
import Input from "../Input";
import { useForm } from "react-hook-form";
import OtpTimer from "./OtpTimer";

function VerifyOtpForm({ onVerify, onResendOtp, loading, error }) {
  const {
    register,
    handleSubmit,
    formState: { errors },
  } = useForm();

  const onSubmit = (data) => {
    onVerify(data.otp);
  };

  return (
    <div className="w-full">
      <form
        onSubmit={handleSubmit(onSubmit)}
        className="w-full max-w-sm mx-auto bg-white p-6 rounded-lg shadow-lg space-y-5"
      >
        {/* Title */}
        <div className="text-center mb-1">
          <h2 className="text-xl font-bold text-gray-900">Verify OTP</h2>
          <p className="text-gray-500 text-sm mt-1">
            Enter the 6-digit code sent to your phone.
          </p>
        </div>

        {/* OTP Input */}
        <div>
          <Input
            type="text"
            label="Enter OTP"
            placeholder="Enter 6-digit OTP"
            maxLength={6}
            className={`w-full border rounded-md px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-emerald-500 ${
              errors.otp ? "border-red-500 ring-red-200" : "border-gray-300"
            }`}
            {...register("otp", {
              required: "OTP is required",
              pattern: {
                value: /^[0-9]{6}$/,
                message: "OTP must be 6 digits",
              },
            })}
          />
          {errors.otp && (
            <p className="text-sm text-red-500 mt-1">{errors.otp.message}</p>
          )}
        </div>

        {/* Timer + Resend */}
        <div className="text-center">
          <OtpTimer onResend={onResendOtp} />
        </div>

        {/* Button */}
        <div className="pt-1">
          <button
            type="submit"
            disabled={loading}
            className={`w-full h-11 flex items-center justify-center font-semibold text-white rounded-md shadow-md transition-all duration-200 ${
              loading
                ? "bg-emerald-400 cursor-not-allowed"
                : "bg-emerald-600 hover:bg-emerald-700 hover:translate-y-[1px]"
            }`}
          >
            {loading ? "Verifying..." : "Verify OTP"}
          </button>
        </div>

        {/* Error Message */}
        {error && (
          <p className="text-center text-sm text-red-500 font-medium">
            {error}
          </p>
        )}

        {/* Footer Note */}
        <p className="text-center text-xs text-gray-500 mt-2">
          Didn’t get the code? You can resend it once the timer ends.
        </p>
      </form>
    </div>
  );
}

export default VerifyOtpForm;
