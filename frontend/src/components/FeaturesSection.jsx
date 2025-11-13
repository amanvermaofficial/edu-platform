import { motion } from "framer-motion";
import { FaChalkboardTeacher, FaClock, FaCheckCircle, FaMobileAlt } from "react-icons/fa";

const features = [
  {
    icon: FaChalkboardTeacher,
    title: "Expert-Led Lessons",
    description:
      "Watch ITI trade theory video classes taught by expert instructors on YouTube.",
    color: "bg-blue-100 text-blue-800",
  },
  {
    icon: FaClock,
    title: "Mock Tests & Quizzes",
    description:
      "Practice anytime with topic-wise and full-length tests to strengthen your concepts.",
    color: "bg-green-100 text-green-800",
  },
  {
    icon: FaCheckCircle,
    title: "Track Your Progress",
    description:
      "View your performance, scores, and improvements in one place.",
    color: "bg-purple-100 text-purple-800",
  },
  {
    icon: FaMobileAlt,
    title: "Mobile App Coming Soon",
    description:
      "Soon available on mobile — learn and practice on the go.",
    color: "bg-amber-100 text-amber-800",
  },
];

const FeaturesSection = () => {
  return (
    <section className="bg-white py-20 px-6">
      <div className="max-w-6xl mx-auto text-center">
        {/* Heading */}
        <motion.h2
          initial={{ opacity: 0, y: -20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.5 }}
          className="text-3xl md:text-5xl font-bold text-black mb-4"
        >
          Platform Features
        </motion.h2>

        {/* Subtext */}
        <motion.p
          initial={{ opacity: 0 }}
          animate={{ opacity: 1 }}
          transition={{ delay: 0.2 }}
          className="text-gray-600 text-base md:text-lg mb-12 max-w-2xl mx-auto"
        >
          Learn, practice, and track your ITI progress — everything you need in one place.
        </motion.p>

        {/* Features Grid */}
        <div className="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
          {features.map((feature, index) => {
            const Icon = feature.icon;
            return (
              <motion.div
                key={index}
                initial={{ opacity: 0, y: 30 }}
                whileInView={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.5, delay: index * 0.1 }}
                viewport={{ once: true }}
                className="bg-gray-50 border border-gray-200 rounded-xl p-8 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center"
              >
                {/* Icon */}
                <div className="text-4xl text-black mb-4">
                  <Icon />
                </div>

                {/* Title with colored background */}
                <h3
                  className={`text-base font-semibold px-3 py-1 rounded-full inline-block mb-3 ${feature.color}`}
                >
                  {feature.title}
                </h3>

                {/* Description */}
                <p className="text-gray-600 text-sm leading-relaxed">
                  {feature.description}
                </p>
              </motion.div>
            );
          })}
        </div>
      </div>
    </section>
  );
};

export default FeaturesSection;
