import React, { useEffect, useState } from "react";
import { getTestimonials } from "../services/review";
import { motion } from "framer-motion";
import Modal from "@mui/material/Modal";
import Box from "@mui/material/Box";

function Testimonials() {
  const [testimonials, setTestimonials] = useState([]);
  const [activeTestimonial, setActiveTestimonial] = useState(null);
  const [pause, setPause] = useState(false);

  useEffect(() => {
    const fetchTestimonials = async () => {
      const res = await getTestimonials();
      setTestimonials(res.data.data);
      console.log(res.data.data);
      
    };
    fetchTestimonials();
  }, []);

  if (!testimonials.length) {
    return (
      <div className="flex justify-center mt-20">
        <p className="text-gray-500">Loading...</p>
      </div>
    );
  }

  return (
    <>
      {/* SECTION */}
      <section className="mt-24 bg-[#fdf6ea] py-16">
        {/* CENTERED CONTAINER */}
        <div className="max-w-6xl mx-auto px-4 overflow-hidden">
          <h1 className="text-3xl font-bold mb-10 text-center">
            Student Testimonials 💬
          </h1>

          {/* SINGLE ROW SLIDER */}
          <motion.div
            className="flex gap-6 cursor-grab"
            drag="x"
            dragConstraints={{ left: -1200, right: 0 }}
            animate={!pause ? { x: ["0%", "-50%"] } : {}}
            transition={{
              repeat: Infinity,
              duration: 28,
              ease: "linear",
            }}
            onMouseEnter={() => setPause(true)}
            onMouseLeave={() => setPause(false)}
          >
            {[...testimonials, ...testimonials].map((testimonial, index) => (
              <div
                key={index}
                onClick={() => setActiveTestimonial(testimonial)}
                className="min-w-[300px] bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition cursor-pointer"
              >
                <div className="flex items-center gap-4 mb-4">
                  <img
                    src={testimonial.student.profile_picture}
                     referrerPolicy="no-referrer"
                    alt={testimonial.student.name}
                    className="w-12 h-12 rounded-full object-cover border"
                  />
                  <h2 className="font-semibold text-gray-800">
                    {testimonial.student.name}
                  </h2>
                </div>

                <p className="text-gray-600 italic line-clamp-3">
                  “{testimonial.description}”
                </p>
              </div>
            ))}
          </motion.div>
        </div>
      </section>

      {/* MODAL */}
      <Modal
        open={!!activeTestimonial}
        onClose={() => setActiveTestimonial(null)}
        slotProps={{
          backdrop: {
            sx: { backgroundColor: "rgba(0,0,0,0.6)" },
          },
        }}
      >
        <Box className="bg-white max-w-xl w-full mx-auto mt-32 p-6 rounded-2xl outline-none relative">
          <button
            onClick={() => setActiveTestimonial(null)}
            className="absolute top-4 right-4 text-xl text-gray-500 hover:text-black"
          >
            ✕
          </button>

          <div className="flex items-center gap-4 mb-6">
            <img
              src={activeTestimonial?.student.profile_picture}
              alt=""
              className="w-16 h-16 rounded-full object-cover border"
            />
            <h2 className="text-xl font-bold text-gray-800">
              {activeTestimonial?.student.name}
            </h2>
          </div>

          <p className="text-gray-700 text-lg leading-relaxed italic">
            “{activeTestimonial?.description}”
          </p>
        </Box>
      </Modal>
    </>
  );
}

export default Testimonials;
