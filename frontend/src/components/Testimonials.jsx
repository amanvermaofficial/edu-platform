import { motion } from "framer-motion";

const testimonials = [
  {
    name: "Rohit Kumar",
    role: "Student",
    feedback:
      "This platform made learning so easy and fun. The mock tests helped me build real confidence!",
    image:
      "https://st.depositphotos.com/1011643/2013/i/450/depositphotos_20131045-happy-male-african-university-student-outdoors.jpg",
  },
  {
    name: "Priya Sharma",
    role: "Learner",
    feedback:
      "Simple explanations, smooth design, and great practice questions. Loved the experience!",
    image:
      "https://media.istockphoto.com/id/1365601848/photo/portrait-of-a-young-woman-carrying-her-schoolbooks-outside-at-college.jpg?s=612x612&w=0&k=20&c=EVxLUZsL0ueYFF1Nixit6hg-DkiV52ddGw_orw9BSJA=",
  },
  {
    name: "Ankit Verma",
    role: "Aspirant",
    feedback:
      "I used to get confused with topics, but the video lessons and progress tracker really helped.",
    image:
      "https://us.images.westend61.de/0001411501pw/portrait-of-confident-young-male-student-in-corridor-of-university-MASF19101.jpg",
  },
  // Add more testimonials here easily
];

const Testimonials = () => {
  return (
    <section className="bg-gradient-to-br from-amber-50 via-white to-amber-100 py-20 px-6">
      <div className="max-w-6xl mx-auto text-center">
        {/* Title */}
        <motion.h2
          initial={{ opacity: 0, x: -30 }}
          whileInView={{ opacity: 1, x: 0 }}
          transition={{ duration: 0.6 }}
          className="text-4xl md:text-5xl font-bold mb-4 text-gray-800"
        >
          What Students Say
        </motion.h2>

        {/* Subtitle */}
        <motion.p
          initial={{ opacity: 0 }}
          whileInView={{ opacity: 1 }}
          transition={{ delay: 0.2 }}
          className="text-gray-600 text-md md:text-lg mb-12 max-w-2xl mx-auto"
        >
          Real feedback from learners who experienced the change in their preparation journey.
        </motion.p>

        {/* ✅ Scrollable Testimonials */}
        <div className="flex overflow-x-auto gap-6 pb-6 scrollbar-thin scrollbar-thumb-amber-300 scrollbar-track-transparent snap-x snap-mandatory">
          {testimonials.map((t, i) => (
            <motion.div
              key={i}
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.5, delay: i * 0.1 }}
              viewport={{ once: true }}
              className="flex-shrink-0 w-80 bg-white p-8 rounded-2xl border border-amber-200 hover:border-amber-400 transition-all shadow-sm hover:shadow-md text-center snap-center"
            >
              <img
                src={t.image}
                alt={t.name}
                className="w-20 h-20 rounded-full mb-5 object-cover mx-auto border border-amber-300"
              />
              <p className="text-gray-700 italic mb-4 leading-relaxed">“{t.feedback}”</p>
              <h4 className="text-lg font-semibold text-gray-900">{t.name}</h4>
              <span className="text-sm text-amber-600">{t.role}</span>
            </motion.div>
          ))}
        </div>
      </div>
    </section>
  );
};

export default Testimonials;
