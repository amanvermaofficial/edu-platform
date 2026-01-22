import React, { useEffect, useState } from 'react'
import { useParams } from 'react-router-dom'
import { getResultReview } from '../../services/quizService';
import { FaLightbulb, FaChevronDown, FaChevronUp } from 'react-icons/fa';


function QuizResultReview() {
    const { quizId } = useParams();
    const [quizResult, setQuizResult] = useState([]);
    const [currentIndex, setCurrentIndex] = useState(0);
    const [loading, setLoading] = useState(true);
    const [showSolution, setShowSolution] = useState(false);


    const getOptionClass = (option) => {
        if (option.is_selected && option.is_correct) {
            return 'bg-green-400'; // correct & selected
        }

        if (option.is_selected && !option.is_correct) {
            return 'bg-red-400 text-white'; // selected but wrong
        }

        if (!option.is_selected && option.is_correct) {
            return 'bg-green-200'; // correct but not selected
        }

        return 'bg-white'; // normal
    }
    useEffect(() => {
        const fetchResult = async () => {
            try {
                const res = await getResultReview(quizId);
                console.log(res);

                setQuizResult(res.data.data.data);
            } catch (error) {
                toast.error("Failed to load quiz result");
                navigate(-1);
            } finally {
                setLoading(false);
            }
        }

        fetchResult();
    }, [quizId]);

    if (loading) {
        return (
            <div className="min-h-screen bg-amber-50 flex justify-center px-4 py-40">
                <div className="w-full max-w-3xl bg-white rounded-2xl shadow-lg p-6 md:p-8 animate-pulse">

                    {/* Question Header Skeleton */}
                    <div className="mb-6 space-y-3">
                        <div className="h-4 w-40 bg-amber-200 rounded"></div>
                        <div className="h-6 w-full bg-gray-200 rounded"></div>
                        <div className="h-6 w-3/4 bg-gray-200 rounded"></div>
                    </div>

                    {/* Options Skeleton */}
                    <div className="space-y-3">
                        {[1, 2, 3, 4].map((_, index) => (
                            <div
                                key={index}
                                className="h-14 bg-gray-100 border border-gray-200 rounded-xl"
                            ></div>
                        ))}
                    </div>

                    {/* Navigation Skeleton */}
                    <div className="flex justify-between mt-8">
                        <div className="h-10 w-24 bg-gray-200 rounded-lg"></div>
                        <div className="h-10 w-24 bg-amber-200 rounded-lg"></div>
                    </div>
                </div>
            </div>
        );
    }



    const question = quizResult.length > 0 ? quizResult[currentIndex] : null;


    return (
        <div className="min-h-screen bg-amber-50 flex justify-center px-4 pt-16">
            <div className="w-full max-w-3xl bg-white rounded-2xl shadow-lg p-6 md:p-8">

                {/* Question Header */}
                <div className="mb-6">
                    <h2 className="text-sm text-amber-600 font-semibold mb-1">
                        Question {currentIndex + 1} of {quizResult.length}
                    </h2>
                    <h1 className="text-lg md:text-xl font-bold text-gray-800">
                        {question?.question_text}
                    </h1>
                </div>

                {/* Options */}
                <div className="space-y-3">
                    {question?.options?.map((option) => (
                        <div
                            key={option.option_id}
                            className={`p-4 border rounded-xl transition-all
                            ${getOptionClass(option)}
                            ${option.is_selected ? 'border-gray-600' : 'border-gray-200'}
                        `}
                        >
                            <div className="flex items-center justify-between">
                                <span className="text-gray-800 font-medium">
                                    {option.option_text}
                                </span>

                                {/* Labels */}
                                {option.is_selected && (
                                    <span className="text-xs px-2 py-1 rounded-full bg-gray-800 text-white">
                                        Selected
                                    </span>
                                )}

                                {!option.is_selected && option.is_correct && (
                                    <span className="text-xs px-2 py-1 rounded-full bg-green-600 text-white">
                                        Correct
                                    </span>
                                )}
                            </div>
                        </div>
                    ))}

                    {/* Explanation Toggle */}
                    <div className="mt-6">
                        <button
                            onClick={() => setShowSolution(prev => !prev)}
                            className="flex items-center gap-2 text-amber-700 font-semibold
                   hover:text-amber-800 transition"
                        >
                           
                            <span>Explanation</span>
                            {showSolution ? <FaChevronUp /> : <FaChevronDown />}
                        </button>

                        {/* Explanation Box */}
                        {showSolution && (
                            <div className="mt-4 p-4 rounded-xl border border-amber-200 bg-amber-50
                        animate-fade-in">
                                <div className="flex items-start gap-3">
                                    <FaLightbulb className="text-amber-500 mt-1" />
                                    <p className="text-gray-700 leading-relaxed">
                                        {question?.solution}
                                    </p>
                                </div>
                            </div>
                        )}
                    </div>


                </div>

                {/* Navigation */}
                <div className="flex justify-between items-center mt-8">
                    <button
                        onClick={() => {
                            setCurrentIndex(currentIndex - 1)
                            setShowSolution(false)
                        }}
                        disabled={currentIndex === 0}
                        className={`px-4 py-2 rounded-lg font-medium
                        ${currentIndex === 0
                                ? 'bg-gray-200 text-gray-400 cursor-not-allowed'
                                : 'bg-amber-200 text-amber-900 hover:bg-amber-300'}
                    `}
                    >
                        Previous
                    </button>

                    <button
                        onClick={() => {
                            setCurrentIndex(currentIndex + 1)
                            setShowSolution(false)
                        }}
                        disabled={currentIndex === quizResult.length - 1}
                        className={`px-4 py-2 rounded-lg font-medium
                        ${currentIndex === quizResult.length - 1
                                ? 'bg-gray-200 text-gray-400 cursor-not-allowed'
                                : 'bg-amber-400 text-white hover:bg-amber-500'}
                    `}
                    >
                        Next
                    </button>
                </div>
            </div>
        </div>
    );

}

export default QuizResultReview
