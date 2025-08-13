import api from "../utils/api"; 

export const sendOtp = async (phone) => {
    return api.post('/send-otp',{phone});
}

export const verifyOtp = async (phone,otp) => {
    return api.post('/verify-otp',{phone,otp});
}