import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate, useParams } from "react-router-dom";
import { toast } from "react-toastify";
import { getQuizzes } from "../../services/quizService";
import { setQuizzes } from "../../store/quizSlice";
import Skeleton from "@mui/material/Skeleton";
import { FaClipboardList, FaPlay } from "react-icons/fa";
import { MdErrorOutline } from "react-icons/md";

function QuizList() {
  const { courseId, tradeId } = useParams();
  const dispatch = useDispatch();
  const quizzes = useSelector((state) => state.quiz.quizzes);
  const navigate = useNavigate();
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    async function fetchQuizzes() {
      try {
        setLoading(true);
        const res = await getQuizzes(courseId, tradeId);
        dispatch(setQuizzes(res.data?.data?.quizzes || []));
      } catch (err) {
        console.error("Failed to load quizzes:", err);
        setError("Failed to load quizzes. Please try again later.");
        toast.error("Failed to load quizzes");
      } finally {
        setLoading(false);
      }
    }
    fetchQuizzes();
  }, [courseId, tradeId, dispatch]);

  // 🟡 Loading State
  if (loading) {
    return (
      <div className="max-w-6xl mx-auto mt-20 p-4">
        <h2 className="text-3xl font-bold mb-8 text-amber-700 flex items-center gap-2 justify-center">
          <FaClipboardList /> Quizzes
        </h2>
        <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
          {Array.from({ length: 6 }).map((_, i) => (
            <div
              key={i}
              className="border border-amber-100 rounded-xl shadow-sm p-6 bg-white"
            >
              <Skeleton variant="text" width="70%" height={30} />
              <Skeleton variant="text" width="90%" height={20} />
              <Skeleton variant="rectangular" width="50%" height={36} className="mt-4 rounded" />
            </div>
          ))}
        </div>
      </div>
    );
  }

  // ❌ Error State
  if (error) {
    return (
      <div className="max-w-2xl mx-auto mt-24 text-center">
        <MdErrorOutline className="mx-auto text-5xl text-red-500 mb-4" />
        <p className="text-lg text-gray-700">{error}</p>
        <button
          onClick={() => window.location.reload()}
          className="mt-6 px-6 py-2 bg-amber-600 text-white rounded-full font-medium hover:bg-amber-700 transition-all"
        >
          Retry
        </button>
      </div>
    );
  }

  // 🟠 Empty State
  if (!quizzes.length) {
    return (
      <div className="max-w-2xl mx-auto mt-24 text-center">
        <FaClipboardList className="mx-auto text-5xl text-amber-500 mb-4" />
        <h2 className="text-2xl font-semibold mb-2 text-gray-800">
          No Quizzes Available
        </h2>
        <p className="text-gray-500">
          There are no quizzes under this trade right now.
        </p>
      </div>
    );
  }

  // 🟢 Quizzes Grid
  return (
    <div className="max-w-6xl mx-auto mt-20 p-4">
      <h2 className="text-3xl font-bold mb-8 text-amber-700 flex items-center gap-2 justify-center">
        <FaClipboardList /> Quizzes
      </h2>

      <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        {quizzes.map((quiz) => (
          <div
            key={quiz.id}
            className="group bg-white border border-amber-100 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 p-6 hover:-translate-y-1"
          >
            <h3 className="text-lg font-semibold text-gray-800 group-hover:text-amber-600 transition mb-2">
              {quiz.title}
            </h3>
            <p className="text-sm text-gray-500 mb-4">
              {quiz.description || "Test your knowledge with this quiz!"}
            </p>
            <button
              onClick={() =>
                navigate(`/courses/${courseId}/trades/${tradeId}/quizzes/${quiz.id}/attempt`)
              }
              className="flex items-center justify-center gap-2 px-4 py-2 w-full bg-amber-600 text-white rounded-full font-medium hover:bg-amber-700 transition-all"
            >
              <FaPlay /> Start Quiz
            </button>
          </div>
        ))}
      </div>
    </div>
  );
}

export default QuizList;
