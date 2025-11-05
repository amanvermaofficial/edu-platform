import React, { useEffect, useState } from "react";
import { Link, useParams } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import { setTrades, selectTrade } from "../../store/tradeSlice";
import { getTradesByCourse } from "../../services/TradeService";
import { Skeleton } from "@mui/material";
import { FaTools } from "react-icons/fa";
import { MdErrorOutline } from "react-icons/md";

function Trades() {
  const { id } = useParams();
  const dispatch = useDispatch();
  const { trades } = useSelector((state) => state.trade);
  const { selectedCourse } = useSelector((state) => state.course);

  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchTrades = async () => {
      try {
        const res = await getTradesByCourse(id);
        dispatch(setTrades(res.data.data.trades));
      } catch (err) {
        console.error("Error fetching trades:", err);
        setError("Failed to load trades. Please try again later.");
      } finally {
        setLoading(false);
      }
    };
    fetchTrades();
  }, [id, dispatch]);

  // Loading State
  if (loading) {
    return (
      <div className="max-w-6xl mx-auto mt-20 p-4">
        <h2 className="text-3xl font-bold mb-8 text-amber-700 flex items-center gap-2">
          <FaTools />
          {selectedCourse ? selectedCourse.name : "Course"} Trades
        </h2>
        <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
          {Array.from({ length: 6 }).map((_, i) => (
            <div
              key={i}
              className="border border-amber-100 rounded-xl shadow-sm p-6 bg-white"
            >
              <Skeleton variant="text" width="70%" height={30} />
              <Skeleton variant="text" width="50%" height={20} />
            </div>
          ))}
        </div>
      </div>
    );
  }

  // Error State
  if (error) {
    return (
      <div className="max-w-2xl mx-auto mt-24 text-center">
        <MdErrorOutline className="mx-auto text-5xl text-red-500 mb-4" />
        <p className="text-lg text-gray-700">{error}</p>
        <button
          onClick={() => window.location.reload()}
          className="mt-6 px-6 py-2 bg-amber-600 text-white rounded-full font-medium hover:bg-amber-700 transition-all"
        >
          Retry
        </button>
      </div>
    );
  }

  //  Empty State
  if (!trades.length) {
    return (
      <div className="max-w-2xl mx-auto mt-24 text-center">
        <FaTools className="mx-auto text-5xl text-amber-500 mb-4" />
        <h2 className="text-2xl font-semibold mb-2 text-gray-800">
          No Trades Available
        </h2>
        <p className="text-gray-500">
          There are no trades under this course right now.
        </p>
      </div>
    );
  }

  // 🟢 Trades Grid
  return (
    <div className="max-w-6xl mx-auto mt-20 p-4">
      <h2 className="text-3xl font-bold mb-8 text-amber-700 flex items-center gap-2">
        <FaTools />
        {selectedCourse ? selectedCourse.name : "Course"} Trades
      </h2>

      <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        {trades.map((trade) => (
          <Link
            key={trade.id}
            to={`/courses/${id}/trades/${trade.id}/quizzes`}
            onClick={() => dispatch(selectTrade(trade))}
            className="group block bg-white border border-amber-100 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 p-6 hover:-translate-y-1"
          >
            <div className="flex items-center justify-between mb-3">
              <h3 className="text-lg font-semibold text-gray-800 group-hover:text-amber-600 transition">
                {trade.name}
              </h3>
            </div>
            <p className="text-sm text-gray-500">
              {trade.description
                ? trade.description
                : "Explore related quizzes for this trade."}
            </p>
          </Link>
        ))}
      </div>
    </div>
  );
}

export default Trades;
