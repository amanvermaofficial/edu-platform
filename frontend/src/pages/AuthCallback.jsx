import { useEffect } from "react";
import { useNavigate } from "react-router-dom";
import { handleGoogleCallback } from "../services/authCallbackService";

const AuthCallback = () => {
  const navigate = useNavigate();

  useEffect(() => {
    const redirectTo = handleGoogleCallback();
    navigate(redirectTo);
  }, []);

  return <p style={{ textAlign: "center" }}>Logging you in...</p>;
};

export default AuthCallback;
