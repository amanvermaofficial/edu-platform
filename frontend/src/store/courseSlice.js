import { createSlice } from "@reduxjs/toolkit";

const courseSlice = createSlice({
    name:'course',
    initialState:{
        courses:[],
        selectedCourses:null,
    },
    reducers:{
        setCourses:(state,action)=>{
            state.courses = action.payload;
        },
        selectCourse: (state,action)=>{
            state.selectedCourses = action.payload;
        }
    }
})

export const {setCourses,selectCourse} = courseSlice.actions;

export default courseSlice.reducer