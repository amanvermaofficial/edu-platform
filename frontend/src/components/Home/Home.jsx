import React from "react";
import { IoIosArrowRoundForward } from "react-icons/io";
import heroImage from "../../assets/hero.png";
import { motion } from "framer-motion";
import Courses from "../Courses/Courses";
import ExploreYoutube from "../Exploreyoutube";
import FeaturesSection from "../FeaturesSection";
import Testimonials from "../Testimonials";
import OtpPage from "../../pages/OtpPage";
import { useNavigate } from "react-router-dom";
import { useSelector } from "react-redux";

export const FadeUp = (delay) => ({
  initial: { opacity: 0, y: 50 },
  animate: {
    opacity: 1,
    y: 0,
    transition: {
      type: "spring",
      stiffness: 100,
      duration: 0.6,
      delay,
      ease: "easeInOut",
    },
  },
});

function Home() {
  const [otpOpen, setOtpOpen] = React.useState(false);
  const navigate = useNavigate();
  const authStatus = useSelector((state) => state.auth.status)

  return (
    <section className="relative overflow-hidden bg-white">
      {/* ✅ Gradient Background */}
      <div className="absolute inset-0 z-0 pointer-events-none">
        <div className="absolute inset-0 bg-gradient-to-br from-amber-100 via-white to-amber-50" />
        <div className="absolute top-0 left-0 w-[500px] h-[500px] bg-amber-300/30 blur-3xl rounded-full opacity-60 -translate-x-40 -translate-y-40" />
        <div className="absolute bottom-0 right-0 w-[400px] h-[400px] bg-amber-200/40 blur-2xl rounded-full opacity-50 translate-x-32 translate-y-32" />
      </div>

      {/* ✅ Actual Content */}
      <div className="relative z-10">
        {/* Hero Section */}
        <div className="flex flex-col lg:flex-row justify-center items-center gap-10 py-20 px-6 md:px-10">
          {/* Text */}
          <div className="max-w-3xl text-center lg:text-left space-y-6">
            <motion.h1
              variants={FadeUp(0.4)}
              initial="initial"
              animate="animate"
              className="text-3xl md:text-5xl font-extrabold leading-snug text-gray-900"
            >
              <span className="text-amber-600">Learn</span> Smart,{" "}
              <span className="text-amber-600">Grow</span> Fast.
            </motion.h1>

            <motion.p
              variants={FadeUp(0.6)}
              initial="initial"
              animate="animate"
              className="text-gray-600 text-base md:text-lg leading-relaxed max-w-xl"
            >
              An all-in-one learning platform offering mock tests, video
              lessons, and progress tracking — designed to make exam
              preparation smarter, faster, and easier.
            </motion.p>

            <motion.div
              variants={FadeUp(0.8)}
              initial="initial"
              animate="animate"
              className="flex justify-center lg:justify-start"
            >
              {!authStatus ? (
                <button
                  onClick={() => navigate('/login')}  
                  className="primary-btn"
                >
                  Get Started
                  <IoIosArrowRoundForward className="text-2xl group-hover:translate-x-2 duration-300" />
                </button>
              ) : (
                <button
                  onClick={() => navigate('/courses')}
                  className="primary-btn"
                >
                  Explore now
                  <IoIosArrowRoundForward className="text-2xl group-hover:translate-x-2 duration-300" />
                </button>
              )}
            </motion.div>
          </div>

          {/* Image */}
          <motion.div
            initial={{ x: 50, opacity: 0 }}
            animate={{ x: 0, opacity: 1 }}
            transition={{ duration: 0.8, ease: "easeInOut" }}
            className="flex justify-center"
          >
            <img
              src={heroImage}
              alt="Learning Illustration"
              className="w-[320px] md:w-[480px] lg:w-[550px] drop-shadow-xl"
            />
          </motion.div>
        </div>

        {/* OTP Modal */}
        <OtpPage open={otpOpen} onClose={() => setOtpOpen(false)} />

        {/* Other Sections */}
        <FeaturesSection />
        <ExploreYoutube />
        <Testimonials />
      </div>
    </section>
  );
}

export default Home;
