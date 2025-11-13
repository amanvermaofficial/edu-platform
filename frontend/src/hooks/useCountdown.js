import { useEffect, useState } from "react";

/**
 * Countdown hook
 * Works directly with backend's end_time (ISO string)
 */
export const useCountdown = (endTime) => {
  const [timeLeft, setTimeLeft] = useState(null);

  useEffect(() => {
    if (!endTime) return;

    const end = new Date(endTime).getTime();

    const updateTimer = () => {
      const now = Date.now();
      const diff = Math.floor((end - now) / 1000);
      setTimeLeft(diff > 0 ? diff : 0);
    };

    updateTimer(); // first call immediately
    const interval = setInterval(updateTimer, 1000);

    return () => clearInterval(interval);
  }, [endTime]);

  const formatTime = (seconds) => {
    if (seconds === null) return "--:--";
    const m = Math.floor(seconds / 60);
    const s = seconds % 60;
    return `${m.toString().padStart(2, "0")}:${s
      .toString()
      .padStart(2, "0")}`;
  };

  return { timeLeft, formatTime };
};
