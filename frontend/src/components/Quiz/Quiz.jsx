import { Link } from "react-router-dom";

const quizzes = [
  {
    id: 1,
    title: "Fashion Design Quiz",
    slug: "fashion-design",
    description: "Test your fashion knowledge.",
  },
  {
    id: 2,
    title: "Cosmetology Quiz",
    slug: "cosmetology",
    description: "Explore beauty and cosmetology.",
  },
  {
    id: 3,
    title: "COPA Quiz",
    slug: "copa",
    description: "Computer basics and applications./Now you can explore more questions and do practice motr better ",
  },
];

const QuizList = () => {
  return (
    <div className="p-6 mt-24">
      <h2 className="text-2xl font-bold mb-6 text-center">Available Quizzes</h2>
      <div className="flex flex-wrap gap-6 justify-center">
        {quizzes.map((quiz) => (
          <Link
            key={quiz.id}
            to={`/quiz/${quiz.slug}/instructions`}
            className="w-72 bg-white shadow hover:shadow-md rounded-xl p-5 border border-gray-200 hover:border-blue-600 transition duration-200"
          >
            <h3 className="text-lg font-semibold mb-2">{quiz.title}</h3>
            <p className="text-sm text-gray-600">{quiz.description}</p>
          </Link>
        ))}
      </div>
    </div>
  );
};

export default QuizList;
