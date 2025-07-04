import { motion } from "framer-motion";
import { FaChalkboardTeacher, FaClock, FaCheckCircle, FaMobileAlt } from "react-icons/fa";

const features = [
  {
    icon: FaChalkboardTeacher,
    title: "Expert-Led Lessons",
    description: "Learn from detailed video lessons designed to simplify tough topics.",
    color: "bg-blue-100 text-blue-600",
  },
  {
    icon: FaClock,
    title: "Mock Tests Anytime",
    description: "Practice with topic-wise and full-length tests whenever you want.",
    color: "bg-green-100 text-green-600",
  },
  {
    icon: FaCheckCircle,
    title: "Track Your Progress",
    description: "See your performance and growth with personalized progress tracking.",
    color: "bg-purple-100 text-purple-600",
  },
  {
    icon: FaMobileAlt,
    title: "Mobile Friendly",
    description: "Coming soon to mobile — learn on the go with our upcoming app.",
    color: "bg-pink-100 text-pink-600",
  },
];

const FeaturesSection = () => {
  return (
    <section className="bg-white pt-16 px-6">
      <div className="max-w-6xl mx-auto text-center">
        <motion.h2
          initial={{ opacity: 0, y: -30 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.5 }}
          className="text-2xl md:text-4xl font-extrabold mb-4 text-gray-800"
        >
          🚀 Platform Features
        </motion.h2>
        <motion.p
          initial={{ opacity: 0 }}
          animate={{ opacity: 1 }}
          transition={{ delay: 0.2 }}
          className="text-sm md:text-lg text-gray-600 mb-10 max-w-2xl mx-auto"
        >
          Everything you need to prepare better — smarter learning, quick practice, and full control over your journey.
        </motion.p>

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
                className="bg-gray-50 p-6 rounded-xl shadow hover:shadow-md transition flex flex-col items-center text-center"
              >
                {/* Centered Icon with Colored Circle */}
                <div
                  className={`w-16 h-16 rounded-full flex items-center justify-center mb-4 text-3xl ${feature.color}`}
                >
                  <Icon />
                </div>
                <h3 className="text-xl font-bold text-gray-800 mb-2">
                  {feature.title}
                </h3>
                <p className="text-gray-600 text-sm">{feature.description}</p>
              </motion.div>
            );
          })}
        </div>
      </div>
    </section>
  );
};

export default FeaturesSection;
