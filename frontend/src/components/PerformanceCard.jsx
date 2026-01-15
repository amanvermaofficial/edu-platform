import React, { useEffect, useState } from "react";
import { getStudentPerformance } from "../services/PerformanceService";
import { useSelector } from "react-redux";

function PerformanceCard() {
  const [performance, setPerformance] = useState(null);
  const [loading, setLoading] = useState(true);

  const  userData = useSelector((state)=>state.auth.userData);

  useEffect(() => {
    async function fetchPerformance() {
      try {
        const res = await getStudentPerformance();
        setPerformance(res.data.data);
        console.log(res.data.data);
        
      } catch (error) {
        console.error("Failed to load performance");
      } finally {
        setLoading(false);
      }
    }

    fetchPerformance();
  }, []);

  if (loading) {
    return (
      <div className="bg-white p-6 rounded-xl shadow animate-pulse">
        <div className="h-4 bg-gray-200 rounded w-1/3 mb-4"></div>
        <div className="h-6 bg-gray-200 rounded w-full"></div>
      </div>
    );
  }

  if (!performance) return null;

  return (
    <div className="bg-white p-6 rounded-xl shadow-sm">
      <h3 className="text-xl font-semibold text-gray-800 mb-4">
        Your Performance 📊
      </h3>

      <div className="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div className="bg-amber-50 rounded-lg p-4 text-center">
          <p className="text-sm text-gray-500">Quizzes Attempted</p>
          <p className="text-2xl font-bold text-amber-600">
            {performance.performance.performance.total_quizzes}
          </p>
        </div>

        <div className="bg-green-50 rounded-lg p-4 text-center">
          <p className="text-sm text-gray-500">Average Score</p>
          <p className="text-2xl font-bold text-green-600">
            {performance.performance.performance.average_score}%
          </p>
        </div>

        <div className="bg-blue-50 rounded-lg p-4 text-center">
          <p className="text-sm text-gray-500">Best Score</p>
          <p className="text-2xl font-bold text-blue-600">
            {performance.performance.performance.best_score}%
          </p>
        </div>
<div className="bg-purple-50 rounded-lg p-4 text-center">
    <p className="text-sm text-gray-500">Last Quiz</p>

    {performance.performance.performance.last_attempt ? (
      <p className="text-2xl font-bold text-purple-600">
        {Math.round(
          (performance.performance.performance.last_attempt.score /
            performance.performance.performance.last_attempt.total_questions) *
            100
        )}%
      </p>
    ) : (
      <p className="text-sm text-gray-400">No attempts</p>
    )}
  </div>
       
      </div>
    </div>
  );
}

export default PerformanceCard;
