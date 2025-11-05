import {createSlice, current} from "@reduxjs/toolkit";

const quizSlice = createSlice({
    name:'quiz',
    initialState:{
        quizzes:[],
        currentQuiz:null,
        result:null
    },
    reducers:{
        setQuizzes:(state,action)=>{
            state.quizzes = action.payload
        },
        setCurrentQuiz:(state,action)=>{
            state.currentQuiz = action.payload
        },
        setResult:(state,action)=>{
            state.result = action.payload
        }
    }
})

export const {setQuizzes,setCurrentQuiz,setResult} = quizSlice.actions
export default quizSlice.reducer