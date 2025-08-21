import React, { useEffect, useState } from 'react'
import WavingHand from '../assets/images/WavingHand.svg'
import { IoIosArrowRoundForward } from "react-icons/io";
import { useSelector } from 'react-redux';
import { getProfile } from '../services/ProfileService';
import ProfileModal from './ProfileModal/ProfileModal';

function Dashboard() {
  const [open, setOpen] = React.useState(false);
  const [profileData,setProfileData] = useState(null)
  const [trades,setTrades] = useState([]);
  
  useEffect(() => {
    async function fetchProfile() {
      const response = await getProfile();
      setProfileData(response.data.data);
      console.log(response.data.data);
      if(!response.data.data.completed_profile){
        setOpen(true);
      }
    }

    fetchProfile();
  }, []);

  return (
    <section className='pt-20 mx-auto my-0 w-[85%]'>
      <div className=' text-start flex flex-col gap-5 mt-10'>
        <div className='flex flex-col gap-2'>
          <div className='flex items-center gap-5'>
            <h1 className='text-5xl font-semibold'>Welcome back, Aman</h1>
            <img src={WavingHand} className="w-16" alt="" />
          </div>
          <p className='text-2xl text-gray-400'>Continue your learning journey today </p>
        </div>
        <div>
            <button className='primary-btn flex justify-center items-center gap-2 '>
              Continue Quiz
              <IoIosArrowRoundForward className='text-xl group-hover:translate-x-2 group-hover:-rotate-45 duration-300' />
            </button>
        </div>
      </div>
      {profileData && <ProfileModal open={open} onClose={() => setOpen(false)} defaultValues={profileData} />}
    </section>

  )
}

export default Dashboard
