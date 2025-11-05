import React, { useEffect, useState } from "react";
import WavingHand from "../assets/images/WavingHand.svg";
import { IoIosArrowRoundForward } from "react-icons/io";
import { useDispatch, useSelector } from "react-redux";
import { getProfile } from "../services/ProfileService";
import ProfileModal from "./Profile/ProfileModal";
import { setUserData } from "../store/authSlice";

function Dashboard() {
  const [open, setOpen] = useState(false);
  const [recommended, setRecommended] = useState([]);
  const dispatch = useDispatch();
  const userData = useSelector((state) => state.auth.userData);

  useEffect(() => {
    async function fetchProfile() {
      const response = await getProfile();
      const user = response.data.data;
      dispatch(setUserData(user));

      // Profile check
      if (!user.completed_profile) setOpen(true);

      // Dummy recommended data
      setRecommended([
        { id: 1, title: "Basic Electrical", category: "Electrician" },
        { id: 2, title: "Plumbing Starter Kit", category: "Plumber" },
      ]);
    }

    fetchProfile();
  }, [dispatch]);

  return (
    <section className="pt-20 px-4 sm:px-10 pb-16 max-w-6xl mx-auto">
      {/* Welcome Section */}
      <div className="bg-amber-50 rounded-2xl p-6 sm:p-10 shadow-sm flex flex-col gap-6 mt-10">
        <div className="flex align-center justify-center flex-col gap-4">
          <div className="flex flex-wrap items-center gap-4 justify-center">
            {userData ? (
              <h1 className="text-3xl sm:text-4xl font-semibold text-gray-800">
                Welcome {userData.name}
              </h1>
            ) : (
              <div className="animate-pulse bg-gray-200 h-8 w-36 rounded"></div>
            )}
            <img src={WavingHand} className="w-12 sm:w-14" alt="👋" />
          </div>

          <p className="text-lg text-gray-500">
            Continue your learning journey today 🚀
          </p>
        </div>
        <div className="flex items-center justify-center">
          <button className="bg-amber-500 hover:bg-amber-600 text-white font-medium px-5 py-2.5 rounded-lg flex items-center gap-2 transition">
            Continue Quiz
            <IoIosArrowRoundForward className="text-2xl" />
          </button>
        </div>
      </div>

      {/* Profile Completion Notice */}
      {!userData?.completed_profile && (
        <div className="bg-amber-100 border-l-4 border-amber-500 p-4 rounded-lg mt-8 flex flex-col sm:flex-row justify-between items-center gap-3">
          <p className="text-amber-700 font-medium text-center sm:text-left">
            Complete your profile to unlock all features.
          </p>
          <button
            onClick={() => setOpen(true)}
            className="bg-amber-500 text-white px-4 py-2 rounded-lg hover:bg-amber-600 transition"
          >
            Complete Now
          </button>
        </div>
      )}

      {/* Recommended Courses (Static for now) */}
      <div className="mt-12">
        <h2 className="text-2xl font-semibold mb-4 text-gray-800">
          Recommended for You
        </h2>
        <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
          {recommended.map((item) => (
            <div
              key={item.id}
              className="border p-5 rounded-xl shadow-sm hover:shadow-md transition bg-white"
            >
              <h3 className="font-semibold text-lg mb-1">{item.title}</h3>
              <p className="text-gray-500 text-sm mb-3">{item.category}</p>
              <button className="w-full bg-amber-500 text-white py-2 rounded-lg hover:bg-amber-600 transition">
                View
              </button>
            </div>
          ))}
        </div>
      </div>

      {/* Profile Modal */}
      {userData && (
        <ProfileModal
          open={open}
          onClose={() => setOpen(false)}
          defaultValues={userData}
        />
      )}
    </section>
  );
}

export default Dashboard;
