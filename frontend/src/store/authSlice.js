import { createSlice } from '@reduxjs/toolkit'
import { set } from 'react-hook-form';

const token = localStorage.getItem('token') || null;

const initialState = {
    status:!!token,
    token: token,
    userData: null
}

const authSlice = createSlice({
    name:'auth',
    initialState,
    reducers:{
        loginSuccess:(state,action)=>{
            state.status = true;
            state.token = action.payload.token;
            state.userData = action.payload.userData;
            localStorage.setItem('token',action.payload.token);
        },
        logout:(state)=>{
            state.status = false;
            state.token = null;
            state.userData = null;
            localStorage.removeItem('token');
        },
        setUserData:(state,action)=>{
            state.userData = action.payload;
        }
    }
})