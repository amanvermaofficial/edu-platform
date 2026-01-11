import React from 'react';

const GoogleLogin = () => {
  const googleLogin = () => {
    window.location.href = "http://127.0.0.1:8000/auth/google";
  };

  return (
    <div className="min-h-screen bg-gradient-to-br from-amber-50 via-white to-amber-100 flex items-center justify-center px-4">
      <div className="w-full max-w-md">
        {/* Login Card */}
        <div className="bg-white rounded-2xl shadow-xl border border-amber-200 p-8">
          
          {/* Logo/Title */}
          <div className="text-center mb-8">
            <h1 className="text-4xl font-bold mb-2">
              <span className="text-gray-800">ITI</span>
              <span className="text-amber-600">Papers</span>
            </h1>
            <p className="text-gray-500 text-sm">Welcome back</p>
          </div>

          {/* Instruction Text */}
          <p className="text-gray-600 text-center mb-6">
            Please login to access your courses and quizzes
          </p>

          {/* Google Login Button */}
          <button
            onClick={googleLogin}
            className="w-full bg-white border-2 border-gray-300 rounded-lg py-3 px-4 flex items-center justify-center gap-3 hover:bg-gray-100 hover:border-amber-500 transition-all duration-200 shadow-sm hover:shadow-md"
          >
            <img
              src="https://developers.google.com/identity/images/g-logo.png"
              alt="Google"
              className="w-5 h-5"
            />
            <span className="text-gray-700 font-medium">
              Continue with Google
            </span>
          </button>

          {/* Terms */}
          <p className="text-xs text-gray-500 text-center mt-6">
            By signing in, you agree to the{' '}
            <a href="#" className="text-amber-600 hover:underline">Terms of Service</a>
            {' '}and{' '}
            <a href="#" className="text-amber-600 hover:underline">Privacy Policy</a>.
          </p>
        </div>
      </div>
    </div>
  );
};

export default GoogleLogin;