import { googleLogin } from "../services/googleLoginService";

const GoogleLogin = () => {
  return (
    <div style={{ textAlign: "center", marginTop: "100px" }}>
      <button
        onClick={googleLogin}
        style={{
          padding: "12px 22px",
          borderRadius: "6px",
          border: "1px solid #ddd",
          cursor: "pointer",
          background: "#fff",
          display: "flex",
          alignItems: "center",
          gap: "10px",
          margin: "auto",
          fontSize: "15px"
        }}
      >
        <img
          src="https://developers.google.com/identity/images/g-logo.png"
          alt="google"
          width="18"
        />
        Continue with Google
      </button>
    </div>
  );
};

export default GoogleLogin;
