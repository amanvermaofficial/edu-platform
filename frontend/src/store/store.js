import { configureStore } from "@reduxjs/toolkit";  
import authReducer from "./authSlice";
import courseReducer from './courseSlice'
import tradeReducer from './tradeSlice'

 const store = configureStore({
    reducer: {
        auth: authReducer,
        course:courseReducer,
        trade:tradeReducer,
    }
})

export default store