import { useEffect, useState } from 'react'
import './App.css'
import Header from './components/Header/Header'
import Home from './components/Home/Home'
import { Outlet, useLocation } from 'react-router-dom'
import Footer from './components/Footer/Footer'
import { useDispatch, useSelector } from 'react-redux'
import { getProfile } from './services/ProfileService'
import { setUserData,logout } from './store/authSlice'
function App() {
  const dispatch = useDispatch();
  const {token,userData} = useSelector((state)=>state.auth || {})
  const location = useLocation();

  const hideLayout = location.pathname.includes('/quizzes/') && location.pathname.includes('/attempt')

  useEffect(()=>{
    async function fetchUser(params) {
      if(token && !userData){
        try {
          const res = await getProfile();
          dispatch(setUserData(res.data.data));
        } catch (error) {
           console.error("Auto fetch profile failed", error);
          dispatch(logout());
        }
      }
    }
    fetchUser();
  },[token,userData,dispatch]);

  return (
    <main className='overflow-x-hidden bg-white text-dark min-h-screen flex flex-col'>
      {!hideLayout && <Header />}
      <main className='flex-grow'>
        <Outlet />
      </main>
        {!hideLayout && <Footer />}
    </main>
  )
}

export default App
