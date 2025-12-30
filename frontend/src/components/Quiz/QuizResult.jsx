import React, { useEffect, useState } from "react";
import { useNavigate, useParams } from "react-router-dom";
import { FaTrophy } from "react-icons/fa";
import { getQuizResult } from "../../services/quizService";
import { toast } from "react-toastify";

function QuizResult() {
  const { quizId } = useParams();
  const navigate = useNavigate();

  const [result, setResult] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchResult = async () => {
      try {
        const res = await getQuizResult(quizId);
        console.log(res);
        
        setResult(res.data.data);
      } catch (error) {
        toast.error("Failed to load quiz result");
        navigate(-1);
      } finally {
        setLoading(false);
      }
    };

    fetchResult();
  }, [quizId]);

  if (loading) {
    return (
      <div className="flex items-center justify-center min-h-screen">
        <p className="text-gray-600 text-lg">Loading result...</p>
      </div>
    );
  }

  if (!result) {
    return (
      <div className="flex items-center justify-center min-h-screen bg-amber-50">
        <p className="text-gray-600 text-lg font-medium">
          No result found!
        </p>
      </div>
    );
  }

  return (
    <div className="flex items-center justify-center min-h-screen bg-gradient-to-br from-amber-50 via-white to-amber-100 px-4">
      <div className="bg-white shadow-xl rounded-2xl p-8 w-full max-w-md text-center">
        <div className="flex items-center justify-center gap-2 mb-6">
          <FaTrophy className="text-amber-600 text-4xl" />
          <h2 className="text-3xl font-bold text-amber-700">Quiz Result</h2>
        </div>

        <div className="space-y-4 text-gray-700">
          <div className="bg-amber-50 rounded-lg py-3">
            <p className="text-lg font-semibold">Score</p>
            <p className="text-3xl font-bold text-amber-600">
              {result.score}
            </p>
          </div>

          <div className="flex justify-between bg-gray-50 rounded-lg px-4 py-3">
            <span>Total Questions</span>
            <span className="font-semibold">
              {result.total_questions}
            </span>
          </div>

          <div className="flex justify-between bg-gray-50 rounded-lg px-4 py-3">
            <span>Wrong Answers</span>
            <span className="font-semibold text-red-500">
              {result.wrong_answers}
            </span>
          </div>

          <div className="flex justify-between bg-gray-50 rounded-lg px-4 py-3">
            <span>Not Attempted</span>
            <span className="font-semibold text-yellow-500">
              {result.skipped_questions}
            </span>
          </div>
        </div>

        <button
          onClick={() => navigate(-2)}
          className="mt-8 w-full bg-amber-600 hover:bg-amber-700 text-white font-semibold py-3 rounded-full"
        >
          Back to Quizzes
        </button>
      </div>
    </div>
  );
}

export default QuizResult;
