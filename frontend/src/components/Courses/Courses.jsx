import React, { useEffect, useState } from "react";
import { useSelector, useDispatch } from "react-redux";
import { setCourses, selectCourse } from "../../store/courseSlice";
import { Link } from "react-router-dom";
import { getCourses } from "../../services/CourseService";
import { Skeleton } from "@mui/material";
import { FaBookOpen, FaRedo } from "react-icons/fa";
import { MdErrorOutline } from "react-icons/md";

function Courses() {
  const dispatch = useDispatch();
  const { courses } = useSelector((state) => state.course);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchCourses = async () => {
      try {
        const res = await getCourses();
        const courseList = res.data?.data?.courses || [];
        console.log(res);
        
        dispatch(setCourses(courseList));
      } catch (err) {
        console.error("Failed to fetch courses:", err);
        setError("Failed to load courses. Please try again later.");
      } finally {
        setLoading(false);
      }
    };
    fetchCourses();
  }, [dispatch]);

  // 🟡 Loading State
  if (loading) {
    return (
      <div className="max-w-5xl mx-auto mt-20 p-4">
        <h2 className="text-3xl font-bold mb-8 text-amber-700 flex items-center gap-2">
          <FaBookOpen /> Courses
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

  // ❌ Error State
  if (error) {
    return (
      <div className="max-w-2xl mx-auto mt-24 text-center">
        <MdErrorOutline className="mx-auto text-5xl text-red-500 mb-4" />
        <p className="text-lg text-gray-700">{error}</p>
        <button
          onClick={() => window.location.reload()}
          className="mt-6 px-6 py-2 bg-amber-600 text-white rounded-full font-medium hover:bg-amber-700 transition-all flex items-center gap-2 mx-auto"
        >
          <FaRedo /> Retry
        </button>
      </div>
    );
  }

  // 🟠 Empty State
  if (!courses?.length) {
    return (
      <div className="max-w-2xl mx-auto mt-24 text-center">
        <FaBookOpen className="mx-auto text-5xl text-amber-500 mb-4" />
        <h2 className="text-2xl font-semibold mb-2 text-gray-800">
          No Courses Available
        </h2>
        <p className="text-gray-500">Please check back later.</p>
      </div>
    );
  }

  // 🟢 Courses Grid
  return (
    <div className="max-w-6xl mx-auto mt-20 p-4">
      <h2 className="text-3xl font-bold mb-8 text-amber-700 flex items-center gap-2">
        <FaBookOpen /> Courses
      </h2>
      <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        {courses.map((course) => (
          <Link
            key={course.id}
            to={`/courses/${course.id}/trades`}
            onClick={() => dispatch(selectCourse(course))}
            className="group block bg-white border border-amber-100 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 p-6 hover:-translate-y-1"
          >
            <div className="flex items-center justify-between mb-3">
              <h3 className="text-lg font-semibold text-gray-800 group-hover:text-amber-600 transition">
                {course.name}
              </h3>
            </div>
            <p className="text-sm text-gray-500">
              Click to view available trades
            </p>
          </Link>
        ))}
      </div>
    </div>
  );
}

export default Courses;
