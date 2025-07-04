import { motion } from "framer-motion";
import { Link } from "react-router-dom";

const FinalCTA = () => {
    
  return (
    <section className="bg-gradient-to-r from-yellow-50 to-white text-gray-700 py-16 px-6">
      <motion.div
        initial={{ opacity: 0, scale: 0.95 }}
        whileInView={{ opacity: 1, scale: 1 }}
        transition={{ duration: 0.6 }}
        viewport={{ once: true }}
        className="max-w-4xl mx-auto text-center"
      >
        <h2 className="text-2xl not-first:md:text-4xl font-bold mb-4">
          Ready to Start Your Learning Journey?
        </h2>
        <p className="text-sm md:text-lg mb-8">
          Create your free account and unlock full access to mock tests, video lessons, and progress tracking.
        </p>
        <Link
          to="/signup"
          className="primary-btn inline-block bg-gray-700 text-white font-semibold text-sm md:text-lg px-6 py-3 rounded-full shadow hover:shadow-md transition hover:bg-gray-100 hover:text-black"
        >
           Create Free Account
        </Link>
      </motion.div>
    </section>
  );
};

export default FinalCTA;
