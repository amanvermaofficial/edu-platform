import store from "../store/store";
import { loginSuccess } from "../store/authSlice";

export const handleGoogleCallback = () => {
  const params = new URLSearchParams(window.location.search);

  const token = params.get("token");
  const redirect = params.get("redirect");

  if (token) {
    store.dispatch(
      loginSuccess({
        token: token,
        userData: null // baad me profile API se fill karoge
      })
    );
  }

  return redirect || "/dashboard";
};
