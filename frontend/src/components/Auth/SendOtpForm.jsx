import React from "react";
import { useForm } from "react-hook-form";
import Input from "../Input";

function SendOtpForm({ onSend, loading, error }) {
  const {
    register,
    handleSubmit,
    formState: { errors },
  } = useForm();

  const onSubmit = (data) => {
    onSend(data.phone);
  };

  return (
    <div className="w-full">
      <form
        onSubmit={handleSubmit(onSubmit)}
        className="w-full max-w-sm mx-auto bg-white p-6 rounded-lg space-y-5"
      >
        {/* Title */}
        <div className="text-center mb-1">
          <h2 className="text-xl font-bold text-gray-900">Verify Your Phone</h2>
          <p className="text-gray-500 text-sm mt-1">
            Enter your phone number to receive a one-time OTP.
          </p>
        </div>

        {/* Phone Input */}
        <div>
          <Input
            type="text"
            label="Phone Number"
            placeholder="Enter your phone number"
            className={`w-full border rounded-md px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-amber-500 ${errors.phone ? "border-red-500 ring-red-200" : "border-gray-300"
              }`}
            {...register("phone", {
              required: "Phone number is required",
              pattern: {
                value: /^[0-9]{10}$/,
                message: "Phone number must be 10 digits",
              },
            })}
          />
          {errors.phone && (
            <p className="text-red-500 text-sm mt-1">{errors.phone.message}</p>
          )}
        </div>

        {/* Button (fixed spacing + better design) */}
        <div className="pt-1">
          <button
            type="submit"
            disabled={loading}
            className={`w-full py-2.5 font-semibold text-white rounded-md shadow-md flex items-center justify-center transition-all duration-200 ${loading
                ? "bg-gray-400 cursor-not-allowed"
                : "primary-btn hover:brightness-95 hover:translate-y-[1px]"
              }`}
          >
            {loading ? "Sending..." : "Send OTP"}
          </button>

        </div>

        {/* Error Message */}
        {error && (
          <p className="text-center text-sm text-red-500 font-medium">
            {error}
          </p>
        )}

        {/* Footer Text */}
        <p className="text-center text-xs text-gray-500 mt-2">
          We’ll send a one-time password (OTP) to verify your phone number.
        </p>
      </form>
    </div>
  );
}

export default SendOtpForm;
