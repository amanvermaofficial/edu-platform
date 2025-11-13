import api from "../utils/api";

export const getQuizzes = (courseId,tradeId)=>{
    return api.get(`/courses/${courseId}/trades/${tradeId}/quizzes`)
}

export const getQuizById = (quizId)=>{
    return api.get(`/quizzes/${quizId}`)
};

export const submitQuiz = (quizId,answers) =>{
    return api.post(`/quizzes/${quizId}/submit`,{answers})
}

export const startQuizAttempt = async (quizId) => {
    return api.post(`/quizzes/${quizId}/start`)
}