import React from 'react'
import { Link } from 'react-router-dom'
import logo from '../../assets/logo.png'

function Header() {
  const NavbarMenu = [
    { name: "Home", slug: "/" },
    { name: "About", slug: "/about" },
    { name: "Quiz", slug: "/quiz" },
    { name: "Courses", slug: "/courses" },
  ]

  return (
    <nav className="fixed top-0 left-0 w-full z-50">
      <div className="backdrop-blur-xl bg-white/10 border-b border-white/20 text-black px-6 md:px-20 py-2 flex justify-between items-center ">
        
        {/* Logo */}
        <div className='flex items-center'>
          <img src={logo} className='w-15' alt="" /> <span className='text-black text-lg font-bold'>ITI Papers</span>
        </div>

        {/* Navigation Links */}
        <div className="hidden md:block">
          <ul className="flex items-center gap-5">
            {NavbarMenu.map((menu, index) => (
              <li key={index}>
                <Link
                  to={menu.slug}
                  className="py-2 px-3 text-black hover:underline transition duration-300"
                >
                  {menu.name}
                </Link>
              </li>
            ))}
            <button className="primary-btn ml-4">Sign In</button>
          </ul>
        </div>
      </div>
    </nav>
  )
}

export default Header
