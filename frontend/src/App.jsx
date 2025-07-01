import { useState } from 'react'
import './App.css'
import Header from './components/Header/Header'
import Home from './components/Home/Home'
import { Outlet } from 'react-router-dom'
import Footer from './components/Footer/Footer'

function App() {

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
