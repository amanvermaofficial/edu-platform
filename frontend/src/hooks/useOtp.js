import { useState } from "react";
import { sendOtp, verifyOtp } from '../services/OtpService'
import { toast } from "react-toastify";


export default function useOtp() {
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);
    const [step, setStep] = useState(1);
    const [phone, setPhone] = useState("");

    const handleSendOtp = async (phoneNumber) => {
        setLoading(true);
        setError(null);
        try {
            await sendOtp(phoneNumber);
            setPhone(phoneNumber);
            setStep(2);
            toast.success("OTP sent successfully");
        } catch (error) {
            toast.error(err.response?.data?.message || "Failed to send OTP");
        } finally {
            setLoading(false);
        }
    };

    const handleVerifyOtp = async (otp) => {
        setLoading(true);
        setError(null);
        try {
            await verifyOtp(phone, otp);
             toast.success("✅ OTP Verified Successfully!");
            setStep(3);
        } catch (error) {
            toast.error(err.response?.data?.message || "Invalid OTP");
        } finally {
            setLoading(false);
        }
    };

    return { step, phone, loading, error, handleSendOtp, handleVerifyOtp };
}