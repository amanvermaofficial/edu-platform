import { motion } from "framer-motion";

const testimonials = [
  {
    name: "Rohit Kumar",
    role: "Student",
    feedback:
      "This platform made learning so easy and fun. The mock tests helped me build real confidence!",
    image: "https://st.depositphotos.com/1011643/2013/i/450/depositphotos_20131045-happy-male-african-university-student-outdoors.jpg",
  },
  {
    name: "Priya Sharma",
    role: "Learner",
    feedback:
      "Simple explanations, smooth design, and great practice questions. Loved the experience!",
    image: "https://media.istockphoto.com/id/1365601848/photo/portrait-of-a-young-woman-carrying-her-schoolbooks-outside-at-college.jpg?s=612x612&w=0&k=20&c=EVxLUZsL0ueYFF1Nixit6hg-DkiV52ddGw_orw9BSJA=",
  },
  {
    name: "Ankit Verma",
    role: "Aspirant",
    feedback:
      "I used to get confused with topics, but the video lessons and progress tracker really helped.",
    image: "https://us.images.westend61.de/0001411501pw/portrait-of-confident-young-male-student-in-corridor-of-university-MASF19101.jpg",
  },
];

const Testimonials = () => {
  return (
    <section className="bg-gradient-to-br from-white-50 to-blue-50 py-16 px-6">
      <div className="max-w-6xl mx-auto text-center">
        <motion.h2
          initial={{ opacity: 0, y: -30 }}
          whileInView={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6 }}
          className="text-3xl md:text-4xl font-extrabold mb-4 text-gray-800"
        >
           What Students Say
        </motion.h2>
        <motion.p
          initial={{ opacity: 0 }}
          whileInView={{ opacity: 1 }}
          transition={{ delay: 0.2 }}
          className="text-sm md:text-lg text-gray-600 mb-12 max-w-2xl mx-auto"
        >
          Real feedback from learners who experienced the change in their preparation journey.
        </motion.p>

        <div className="grid gap-8 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
          {testimonials.map((t, i) => (
            <motion.div
              key={i}
              initial={{ opacity: 0, y: 40 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.5, delay: i * 0.1 }}
              viewport={{ once: true }}
              className="bg-white p-6 rounded-2xl shadow hover:shadow-md transition text-center"
            >
              <img
                src={t.image}
                alt={t.name}
                className="w-16 h-16 rounded-full mb-4 object-cover mx-auto"
              />
              <p className="text-gray-700 italic mb-4">“{t.feedback}”</p>
              <h4 className="text-lg font-bold text-gray-800">{t.name}</h4>
              <span className="text-sm text-gray-500">{t.role}</span>
            </motion.div>
          ))}
        </div>
      </div>
    </section>
  );
};

export default Testimonials;
