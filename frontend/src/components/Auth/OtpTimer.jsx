import React, {useState, useEffect } from 'react'

function OtpTimer({ duration = 60 , onResend}) {
    const [timeLeft, setTimeLeft] = useState(duration)

    useEffect(() => {
        if (timeLeft <= 0) return;
        const timer = setTimeout(() => setTimeLeft((t) => t - 1), 1000);
        return () => clearTimeout(timer);
    }, [timeLeft]);

    const handleResendClick = () => {
        onResend();
        setTimeLeft(duration);
    };

    return (
        <div className='text-end'>
            {timeLeft > 0 ? (
                <p className='text-sm text-gray-600'>Resend OTP in {timeLeft}s</p>
            ) : (
                <button className='text-sm text-blue-600' onClick={handleResendClick}>Resend OTP</button>
            )}
        </div>
    )

   // return <p>Resend OTP in {timeLeft}s</p>;
}

export default OtpTimer
