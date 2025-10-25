import React, { useEffect } from 'react'
import { selectCourse } from '../../store/courseSlice'
import { Link, useParams } from 'react-router-dom'
import { useDispatch, useSelector } from 'react-redux';
import { setTrades,selectTrade } from '../../store/tradeSlice';
import { getTradesByCourse } from '../../services/TradeService';

function Trades() {
  const {id} = useParams();
  const dispatch = useDispatch();

  const {trades} = useSelector((state)=>state.trade)
  const {selectedCourse} = useSelector((state)=>state.course)

  useEffect(()=>{
    const fetchTrades = async()=>{
      try {
        const res = await getTradesByCourse(id);
        dispatch(setTrades(res.data.data.trades));
      } catch (error) {
        console.log('Error fetching trades:',error);
      }
    }
    fetchTrades();
  },[id,dispatch])

  return (
    <div className="max-w-3xl mx-auto p-4 mt-20">
      <h1 className='text-2xl font-bold mb-4'>{selectedCourse?selectedCourse.name : 'Course'} Trades</h1>
      {trades.length===0?(
        <p className="text-gray-500">Not available any Trades.</p>
      ):(
        <ul className="grid gap-3 sm:grid-cols-2">
          {trades.map((trade)=>(
            <li
            key={trade.id}
            className="border p-4 rounded-lg hover:shadow-md transition"
            >
              <Link 
                to={`/courses/${id}/trades/${trade.id}/quizzes`}
                onClick={()=>dispatch(selectTrade(trade))}
                 className="block text-blue-600 font-semibold hover:underline"
              >
                {trade.name}
              </Link>
              {trade.description && (
                 <p className="text-gray-600 text-sm mt-1">{trade.description}</p>
              )}
            </li>
          ))}
        </ul>
      )}
    </div>
  )
}

export default Trades
