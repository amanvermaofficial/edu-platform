import React, { useState } from 'react'
import { Link } from 'react-router-dom'
import logo from '../../assets/logo.png'
import { useSelector } from 'react-redux'
import { useNavigate } from 'react-router-dom'
import ProfileMenu from '../Profile/ProfileMenu'
import { HiOutlineMenuAlt3, HiX } from 'react-icons/hi' 

function Header() {
  const authStatus = useSelector((state) => state.auth.status)
  const navigate = useNavigate()
  const [isMenuOpen, setIsMenuOpen] = useState(false)

  const NavbarMenu = [
    { name: "Home", slug: "/", active: !authStatus },
    { name: "About", slug: "/about", active: !authStatus },
    { name: "Dashboard", slug: "/dashboard", active: authStatus },
    { name: "Quiz", slug: "/courses", active: true },
  ]

  const handleProfile = () => navigate('/profile')

  const handleLogout = () => {
    localStorage.removeItem("token")
    navigate('/')
    window.location.reload()
  }

  const handleMenuClick = (slug) => {
    if (!authStatus && (slug === '/dashboard' || slug === '/courses')) {
      navigate('/login')
    } else {
      navigate(slug)
    }
    setIsMenuOpen(false)
  }

  return (
    <nav className="fixed top-0 left-0 w-full z-50">
      <div className="backdrop-blur-xl bg-white/10 border-b border-white/20 text-black px-6 md:px-20 py-2 flex justify-between items-center">

        {/* Logo */}
        <div className="flex items-center gap-2">
          <img src={logo} className="w-14" alt="logo" />
          <div className="flex flex-col justify-start">
            <h1 className="text-xl font-bold ">
              <span className="text-gray-800">ITI</span>
              <span className="text-amber-600">Papers</span>
            </h1>
            <p className="text-sm">Mindset of Growth</p>
          </div>
        </div>

        {/* Desktop Menu */}
        <div className="hidden md:block">
          <ul className="flex items-center gap-5">
            {NavbarMenu.map((menu, index) =>
              menu.active ? (
                <li key={index}>
                  <button
                    onClick={() => handleMenuClick(menu.slug)}
                    className="py-2 px-3 text-black hover:underline transition duration-300"
                  >
                    {menu.name}
                  </button>

                </li>
              ) : null
            )}
            {authStatus ? (
              <ProfileMenu onProfile={handleProfile} onLogout={handleLogout} />
            ) : (
              <button className="primary-btn ml-4" onClick={() => navigate('/login')}>Get Start</button>
            )}
          </ul>
        </div>

        {/* Mobile Hamburger */}
        <div className="md:hidden">
          {isMenuOpen ? (
            <HiX
              className="text-3xl cursor-pointer text-black"
              onClick={() => setIsMenuOpen(false)}
            />
          ) : (
            <HiOutlineMenuAlt3
              className="text-3xl cursor-pointer text-black"
              onClick={() => setIsMenuOpen(true)}
            />
          )}
        </div>
      </div>

      {/* Mobile Dropdown Menu */}
      {isMenuOpen && (
        <div className="md:hidden backdrop-blur-lg bg-white/30 border-t border-white/20 px-6 py-4">
          <ul className="flex flex-col gap-4">
            {NavbarMenu.map((menu, index) =>
              menu.active ? (
                <li key={index}>
                  <button
                    onClick={() => handleMenuClick(menu.slug)}
                    className=" text-black text-lg font-medium hover:underline"
                  >
                    {menu.name}
                  </button>
                </li>
              ) : null
            )}
            {authStatus ? (
              <ProfileMenu onProfile={handleProfile} onLogout={handleLogout} />
            ) : null}
          </ul>
        </div>
      )}
      
    </nav>
  )
}

export default Header
