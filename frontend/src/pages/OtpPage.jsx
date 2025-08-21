import SendOtpForm from "../components/Auth/SendOtpForm";
import { Dialog, DialogTitle, DialogContent, IconButton } from "@mui/material";
import VerifyOtpForm from "../components/Auth/VerifyOtpForm";
import useOtp from "../hooks/useOtp";
import { ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

function OtpPage({ open, onClose }) {
  const { step, phone, loading, error, handleSendOtp, handleVerifyOtp } = useOtp();

  return (
    <>
      <Dialog open={open} onClose={onClose} fullWidth maxWidth="xs">
        <DialogTitle sx={{ m: 0, p: 2, position: "relative" }}>
          {step === 1 ? "Send OTP" : "Verify OTP"}
          <IconButton
            aria-label="close"
            onClick={onClose}
            sx={{
              position: "absolute",
              right: 8,
              top: 8,
              color: (theme) => theme.palette.grey[500],
              fontSize: "1.2rem"
            }}
          >
            ✖
          </IconButton>
        </DialogTitle>

        <DialogContent dividers>
          {step === 1 && (
            <SendOtpForm onSend={handleSendOtp} loading={loading} error={error} />
          )}
          {step === 2 && (
            <VerifyOtpForm
              onVerify={handleVerifyOtp}
              onResendOtp={() => handleSendOtp(phone)}
              loading={loading}
              error={error}
            />
          )}
        </DialogContent>
      </Dialog>

      <ToastContainer position="top-right" autoClose={3000} />
    </>
  );
}

export default OtpPage;
