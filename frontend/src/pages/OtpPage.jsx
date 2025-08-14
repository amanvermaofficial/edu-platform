import SendOtpForm from "../components/Auth/SendOtpForm"
import VerifyOtpForm from "../components/Auth/VerifyOtpForm"
import useOtp from "../hooks/useOtp"
import { ToastContainer } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
function OtpPage() {
  const { step, loading, error, handleSendOtp
    , handleVerifyOtp
  } = useOtp();
  return (
    <div className="flex justify-center items-center h-screen">
      {step === 1 && <SendOtpForm onSend={handleSendOtp} loading={loading} error={error} />}
      {step === 2 && <VerifyOtpForm onVerify={handleVerifyOtp} loading={loading} error={error} />}
      <ToastContainer position="top-right" autoClose={3000} />
    </div>
  )
}

export default OtpPage
