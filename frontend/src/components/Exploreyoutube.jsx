import { motion } from "framer-motion";
import { FaYoutube } from "react-icons/fa";
import laptop from "../assets/images/laptop.png"; // ✅ Make sure this is correct path
import { Link } from "react-router-dom";

const ExploreYoutube = () => {
  return (
    <section className="bg-gradient-to-br from-yellow-50 to-white py-16 px-6">
      <div className="max-w-6xl mx-auto flex flex-col-reverse md:flex-row items-center gap-8">
        
        {/* ✅ Text Content with Animation */}
       <motion.div
          initial={{ x: -100, opacity: 0 }}
          whileInView={{ x: 0, opacity: 1 }}
          viewport={{ once: true, amount: 0.3 }}
          transition={{ 
            duration: 0.8, 
            ease: "easeOut",
            type: "spring",
            stiffness: 100
          }}
          className="flex-1"
        >
        <motion.h2 
            initial={{ y: 30, opacity: 0 }}
            whileInView={{ y: 0, opacity: 1 }}
            viewport={{ once: true }}
            transition={{ delay: 0.2, duration: 0.6 }}
            className="text-2xl md:text-4xl font-extrabold text-gray-800 mb-4"
          >
            📺 Explore Our Engaging YouTube Channel
          </motion.h2>
          <motion.p 
            initial={{ y: 30, opacity: 0 }}
            whileInView={{ y: 0, opacity: 1 }}
            viewport={{ once: true }}
            transition={{ delay: 0.4, duration: 0.6 }}
            className="text-sm md:text-lg text-gray-600 mb-6"
          >
            Follow our channel for free learning resources, mock tests, and smart exam preparation.
          </motion.p>
          <Link
            to="https://www.youtube.com/@Itipapers"
            target="_blank"
            className="inline-flex items-center gap-2 bg-rose-700 text-white px-6 py-3 rounded-lg font-medium text-lg hover:bg-red-700 transition"
          >
            <FaYoutube className="text-2xl" />
            Visit Channel
          </Link>
        </motion.div>

        {/* ✅ Image with Animation */}
       <motion.div
          initial={{ x: 100, opacity: 0, scale: 0.8 }}
          whileInView={{ x: 0, opacity: 1, scale: 1 }}
          viewport={{ once: true, amount: 0.3 }}
          transition={{ 
            duration: 0.8, 
            delay: 0.3,
            ease: "easeOut",
            type: "spring",
            stiffness: 100
          }}
          className="flex-1"
        >
          <img
            src={laptop}
            alt="Learning on Laptop"
            className="w-full max-w-md mx-auto"
          />
        </motion.div>
      </div>
    </section>
  );
};

export default ExploreYoutube;
