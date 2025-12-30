import React, { useEffect, useRef, useState } from "react";
import { useDispatch } from "react-redux";
import { useNavigate, useParams } from "react-router-dom";
import { getQuizById, submitQuiz } from "../../services/quizService";
import { setResult } from "../../store/quizSlice";
import { toast } from "react-toastify";
import { FaQuestionCircle } from "react-icons/fa";
import { startQuizAttempt } from "../../services/quizService";
import { useCountdown } from "../../hooks/useCountdown";
import Swal from "sweetalert2";


function QuizAttempt() {
  const { quizId } = useParams();
  const [quiz, setQuiz] = useState(null);
  const [answers, setAnswers] = useState({});
  const [currentIndex, setCurrentIndex] = useState(0);
  const navigate = useNavigate();
  const dispatch = useDispatch();
  const [loading, setLoading] = useState(true);
  const [attemptInfo, setAttemptInfo] = useState(null)


  const { timeLeft, formatTime } = useCountdown(attemptInfo?.end_time);

  const startedRef = useRef(false);


  useEffect(() => {
    if (startedRef.current) return;
    startedRef.current = true;

    const initializeQuiz = async () => {
      try {
        setLoading(true);
        const startRes = await startQuizAttempt(quizId);
        const status = startRes.data?.status || startRes.data?.data?.status;
        console.log(status)
        if (status === "COMPLETED") {
          toast.info("You have already m attempted this quiz");
          navigate(`/quiz-result/${quizId}`);
          return;
        }
        setAttemptInfo(startRes.data?.data);

        const res = await getQuizById(quizId);
        setQuiz(res.data?.data?.quiz);
      } catch (error) {
        toast.error("Failed to load quiz");
        navigate(-1);
      } finally {
        setLoading(false);
      }
    };
    initializeQuiz();
  }, [quizId]);

  useEffect(() => {
    if (timeLeft === 0) handleSubmit();
  }, [timeLeft])



  const handleAnswer = (questionId, optionId) => {
    setAnswers((prev) => ({
      ...prev,
      [questionId]: optionId,
    }));
  };


  const isNavigatingRef = useRef(false)

  const handleNext = () => {
    if (isNavigatingRef.current) return;
    isNavigatingRef.current = true;
    if (currentIndex < quiz.questions.length - 1) {
      setCurrentIndex(prev => {
        const nextIndex = Math.min(prev + 1, quiz.questions.length - 1);
        return nextIndex;
      });

      setTimeout(() => {
        isNavigatingRef.current = false;
      }, 100)
    }
  };

  const handleSubmit = async () => {
    Swal.fire({
      title: "Submit Quiz?",
      text: "Are you sure you want to submit your answers?",
      icon: "warning",
      confirmButtonText: "OK",
      allowOutsideClick: false,
      allowEscapeKey: false,
    }).then(async (result) => {
      if (result.isConfirmed) {
        try {
          const formattedAnswers = Object.keys(answers).map((questionId) => ({
            question_id: parseInt(questionId),
            selected_option_id: answers[questionId],
          }));

          const res = await submitQuiz(quizId, formattedAnswers);
          dispatch(setResult(res.data.data));
          navigate(`/quiz-result/${quizId}`);
        } catch (error) {
          Swal.fire("Error", "Failed to submit quiz", "error");
        }
      }
    });
  };


  // 🟡 Loading State
  if (loading) {
    return (
      <div className="flex flex-col justify-center items-center h-[80vh] space-y-4">
        <div className="h-12 w-12 rounded-full border-4 border-amber-400 border-t-transparent animate-spin"></div>
        <p className="text-gray-600 text-lg font-medium">Loading quiz...</p>
      </div>
    );
  }

   if (!quiz)
    return (
      <div className="flex flex-col justify-center items-center h-[80vh] space-y-4 bg-amber-50">
        <div className="h-12 w-12 rounded-full bg-amber-500 animate-pulse"></div>
        <p className="text-amber-700 text-lg animate-pulse">Loading...</p>
      </div>
    );


  const questions = quiz?.questions || [];
  const question = questions[currentIndex];
  if (!quiz.questions || quiz.questions.length === 0) {
    return (
      <div className="flex justify-center items-center h-[80vh]">
        <p className="text-gray-600 text-lg">No questions available.</p>
      </div>
    );
  }

  if (!question) {
    return (
      <div className="flex justify-center items-center h-[80vh]">
        <p className="text-gray-600 text-lg">Loading question...</p>
      </div>
    );
  }


  // 🟢 Main UI
  return (
    <div className="flex justify-center items-center min-h-screen bg-gradient-to-br from-amber-50 via-white to-amber-100 px-4 sm:px-6 lg:px-8">
      <div className="w-full max-w-2xl bg-white shadow-xl rounded-2xl p-6 sm:p-8 transition-all duration-300">
        {/* Custom Quiz Header */}
        <div className="flex justify-between items-center bg-amber-600 text-white px-5 py-3 rounded-t-2xl shadow-md mb-6">
          <button
            onClick={() => {
              if (window.confirm("Are you sure you want to exit the quiz? Unsaved answers will be lost.")) {
                navigate("/"); // or navigate(-1)
              }
            }}
            className="text-sm sm:text-base font-medium bg-white/20 hover:bg-white/30 px-4 py-2 rounded-full transition-all"
          >
            Exit Quiz
          </button>

          {/* Timer (dummy for now) */}
          <div className="text-lg font-semibold tracking-wide">
            ⏱️{timeLeft !== null ? formatTime(timeLeft) : 'Loading..'}
          </div>
        </div>

        {/* Header */}
        <div className="flex items-center justify-center gap-2 mb-6">
          <FaQuestionCircle className="text-amber-600 text-3xl sm:text-4xl" />
          <h1 className="text-2xl sm:text-3xl font-bold text-amber-700 text-center">
            {quiz.title}
          </h1>
        </div>

        {/* Progress */}
        <div className="text-center text-gray-600 mb-6 text-sm sm:text-base">
          Question {currentIndex + 1} of {quiz.questions.length}
        </div>

        {/* Question */}
        <div className="mb-5">
          <p className="font-semibold text-base sm:text-lg text-gray-900 mb-3 leading-relaxed">
            {question?.question_text}
          </p>

          <div className="space-y-3">
            {question?.options?.map((option) => (
              <label
                key={option.id}
                className={`flex items-center gap-3 p-3 border rounded-lg cursor-pointer transition-all duration-200 text-sm sm:text-base ${answers[question.id] === option.id
                  ? "bg-amber-50 border-amber-500 text-amber-700 shadow-sm"
                  : "bg-white border-gray-300 hover:bg-gray-50"
                  }`}
              >
                <input
                  type="radio"
                  name={`question-${question.id}`}
                  value={option.id}
                  checked={answers[question.id] === option.id}
                  onChange={() => handleAnswer(question.id, option.id)}
                  className="accent-amber-600 h-4 w-4 sm:h-5 sm:w-5"
                />
                <span className="text-gray-800">{option.option_text}</span>
              </label>
            ))}
          </div>
        </div>

        {/* Navigation Buttons */}
        <div className="flex justify-between mt-8">
          {currentIndex > 0 ? (
            <button
              onClick={() => setCurrentIndex((prev) => prev - 1)}
              className="px-4 sm:px-6 py-2 border border-gray-300 rounded-full text-gray-700 hover:bg-gray-100 transition-all text-sm sm:text-base"
            >
              Previous
            </button>
          ) : (
            <div />
          )}

          {currentIndex < quiz.questions.length - 1 ? (
            <button
              onClick={handleNext}
              className="px-5 sm:px-7 py-2 bg-amber-600 text-white rounded-full font-medium hover:bg-amber-700 transition-all text-sm sm:text-base"
            >
              Next
            </button>
          ) : (
            <button
              onClick={handleSubmit}
              className="px-5 sm:px-7 py-2 bg-green-600 text-white rounded-full font-medium hover:bg-green-700 transition-all text-sm sm:text-base"
            >
              Submit
            </button>
          )}
        </div>
      </div>
    </div>
  );
}

export default QuizAttempt;
