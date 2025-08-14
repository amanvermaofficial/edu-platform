import React from 'react'
import Input from '../Input';
import { useForm } from 'react-hook-form';
import OtpTimer from './OtpTimer';

function VerifyOtpForm({ onVerify, loading, error }) {
    const { register, handleSubmit, formState: { errors } } = useForm();

    const onSubmit = (data) => {
        onVerify(data.otp)
    }

    return (
        <form
            onSubmit={handleSubmit(onSubmit)}
            className="max-w-sm mx-auto p-6 bg-white shadow-md rounded-lg space-y-4"
        >
            <div>
                <Input
                    label="Enter OTP"
                    type="text"
                    placeholder="Enter 6-digit OTP"
                    maxLength={6}
                    className={errors.otp ? "border-red-500" : ""}
                    {...register('otp', {
                        required: "OTP is required",
                        pattern: {
                            value: /^[0-9]{6}$/,
                            message: "OTP must be 6 digits"
                        }
                    })}
                />
                {errors.otp && (
                    <p className="text-sm text-red-500 mt-1">{errors.otp.message}</p>
                )}
            </div>

            <OtpTimer />

            <button
                type="submit"
                disabled={loading}
                className={`w-full py-2 text-white rounded-md ${loading
                        ? "bg-green-400 cursor-not-allowed"
                        : "bg-green-600 hover:bg-green-700"
                    }`}
            >
                {loading ? "Verifying..." : "Verify OTP"}
            </button>

            {error && <p className="text-sm text-red-500">{error}</p>}
        </form>
    )
}

export default VerifyOtpForm
