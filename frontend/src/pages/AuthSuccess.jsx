import { useEffect } from "react";
import { useNavigate } from "react-router-dom";
import { useDispatch } from "react-redux";
import { loginSuccess } from "../store/authSlice";
import api from "../utils/api";

const AuthSuccess = () => {
  const navigate = useNavigate();
  const dispatch = useDispatch();

  useEffect(() => {
    const params = new URLSearchParams(window.location.search);
    const token = params.get("token");
    const error = params.get("error");

    if (error) {
      navigate("/login");
      return;
    }

    if (token) {
      // Token save karo
      localStorage.setItem("token", token);
      dispatch(loginSuccess({ token }));

      // User data fetch karo
      api.get("/me")
        .then((response) => {
          dispatch(loginSuccess({ 
            token, 
            userData: response.data.user 
          }));
          navigate("/dashboard");
        })
        .catch(() => {
          navigate("/login");
        });
    } else {
      navigate("/login");
    }
  }, [navigate, dispatch]);

  return (
    <div style={{ textAlign: "center", marginTop: "100px" }}>
      <p>Logging you in...</p>
    </div>
  );
};

export default AuthSuccess;