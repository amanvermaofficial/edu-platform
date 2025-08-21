import { useState } from "react";
import { sendOtp, verifyOtp } from '../services/OtpService'
import { toast } from "react-toastify";
import { loginSuccess } from "../store/authSlice";
import {useDispatch,useSelector} from 'react-redux'
import { useNavigate } from "react-router-dom";


export default function useOtp() {
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);
    const [step, setStep] = useState(1);
    const [phone, setPhone] = useState("");
    const dispatch = useDispatch();
    const navigate = useNavigate();
    const userData = useSelector((state) => state.auth.token);

    const handleSendOtp = async (phoneNumber) => {
        setLoading(true);
        setError(null);
        try {
            await sendOtp(phoneNumber);
            setPhone(phoneNumber);
            setStep(2);
            toast.success("OTP sent successfully");
        } catch (error) {
            toast.error(error       .response?.data?.message || "Failed to send OTP");
        } finally {
            setLoading(false);
        }
    };

    const handleVerifyOtp = async (otp) => {
        setLoading(true);
        setError(null);
        try {
            const res = await verifyOtp(phone, otp);
            dispatch(
                loginSuccess({ token: res.data.data.token, userData: null })
            );
            console.log(userData);
             toast.success(res.data.message);
            
              
             
            navigate('/dashboard');
            console.log(res.data.data.redirect);
            setStep(3);
        } catch (error) {
            toast.error(error.response?.data?.message || "Invalid OTP");
        } finally {
            setLoading(false);
        }
    };

    return { step, phone, loading, error, handleSendOtp, handleVerifyOtp };
}