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
  <div className="flex items-center justify-center min-h-screen bg-amber-50 px-4">
    <div className="bg-white shadow-lg rounded-xl p-6 w-full max-w-md text-center">
      
      {/* Header */}
      <div className="flex items-center justify-center gap-2 mb-6">
        <FaTrophy className="text-amber-600 text-3xl" />
        <h2 className="text-2xl font-bold text-gray-800">
          Quiz Result
        </h2>
      </div>

      {/* Score */}
      <div className="bg-amber-50 rounded-lg py-4 mb-6">
        <p className="text-sm text-gray-600">Score</p>
        <p className="text-3xl font-bold text-amber-700">
          {result.score}
        </p>
      </div>

      {/* Details */}
      <div className="space-y-3 text-gray-700 mb-6">
        <div className="flex justify-between bg-gray-50 rounded-md px-4 py-2">
          <span>Total Questions</span>
          <span className="font-semibold">
            {result.total_questions}
          </span>
        </div>

        <div className="flex justify-between bg-gray-50 rounded-md px-4 py-2">
          <span>Wrong Answers</span>
          <span className="font-semibold text-red-500">
            {result.wrong_answers}
          </span>
        </div>

        <div className="flex justify-between bg-gray-50 rounded-md px-4 py-2">
          <span>Not Attempted</span>
          <span className="font-semibold text-yellow-600">
            {result.skipped_questions}
          </span>
        </div>
      </div>

      {/* Buttons side by side */}
      <div className="flex gap-3">
        <button
          onClick={() => navigate(-2)}
          className="w-1/2 border border-amber-500 text-amber-700 hover:bg-amber-50 font-semibold py-2.5 rounded-lg"
        >
          Back
        </button>

        <button
          onClick={() => navigate(`/quiz-result/${quizId}/result-review`)}
          className="w-1/2 bg-amber-600 hover:bg-amber-700 text-white font-semibold py-2.5 rounded-lg"
        >
          Review
        </button>
      </div>
    </div>
  </div>
);


}

export default QuizResult;
