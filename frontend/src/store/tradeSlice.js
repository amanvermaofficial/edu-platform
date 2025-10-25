import { createSlice } from "@reduxjs/toolkit";

const tradeSlice = createSlice({
    name:'trade',
    initialState:{
        trades:[],
        selectedTrade:null,
    },
    reducers: {
        setTrades: (state,action)=>{
            state.trades = action.payload;
        },
        selectTrade: (state,action)=>{
            state.selectedTrade=action.payload;
        }
    }
});

export const {setTrades,selectTrade} = tradeSlice.actions
export default tradeSlice.reducer;