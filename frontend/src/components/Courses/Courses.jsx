import React, { useEffect } from 'react'
import {useSelector,useDispatch} from 'react-redux';
import { setCourses,selectCourse } from '../../store/courseSlice';
import {Link} from 'react-router-dom';
import { getCourses } from '../../services/CourseService';

function Courses() {
    const dispatch = useDispatch();
    const {courses} = useSelector((state)=>state.course);

    useEffect(()=>{
        const fetchCourses = async ()=>{
            const res = await getCourses();
            dispatch(setCourses(res.data.data.courses));
        };
        fetchCourses()
    },[dispatch])
  return (
    <div className="max-w-2xl mx-auto mt-20">
      <h2 className="text-2xl font-bold mb-4">Courses</h2>
      <ul className="space-y-2">
        {courses.map((course) => (
          <li key={course.id} className="border p-3 rounded hover:bg-gray-50">
            <Link
              to={`/courses/${course.id}/trades`}
              onClick={() => dispatch(selectCourse(course))} // ✅ Selected course set
              className="text-blue-600 font-medium"
            >
              {course.name}
            </Link>
          </li>
        ))}
      </ul>
    </div>
  )
}

export default Courses
