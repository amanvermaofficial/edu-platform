import { useEffect, useState } from 'react'
import './App.css'
import Header from './components/Header/Header'
import Home from './components/Home/Home'
import { Outlet } from 'react-router-dom'
import Footer from './components/Footer/Footer'
import { useDispatch, useSelector } from 'react-redux'
import { getProfile } from './services/ProfileService'
import { setUserData,logout } from './store/authSlice'
function App() {
  const dispatch = useDispatch();
  const {token,userData} = useSelector((state)=>state.auth || {})

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
      <Header />
      <main className='flex-grow'>
        <Outlet />
      </main>
      <Footer />
    </main>
  )
}

export default App
