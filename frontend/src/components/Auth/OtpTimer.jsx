import React, {useState, useEffect } from 'react'

function OtpTimer({ duration = 60 }) {
    const [timeLeft, setTimeLeft] = useState(duration)

    useEffect(() => {
        if (timeLeft <= 0) return;
        const timer = setTimeout(() => setTimeLeft((t) => t - 1), 1000);
        return () => clearTimeout(timer);
    }, [timeLeft]);

    return <p>Resend OTP in {timeLeft}s</p>;
}

export default OtpTimer
