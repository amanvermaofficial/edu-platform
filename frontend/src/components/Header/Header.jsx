import React from 'react'

function Header() {
  const NavbarMenu = [
    {
      name: "Home",
      slug: "/",
      active: true
    },
    {
      name: "About",
      slug: "/about",
      active: true
    },
    {
      name: "Quiz",
      slug: "/quiz",
      active: true
    },
    {
      name: "Courses",
      slug: "/courses",
      active: true
    },
  ]
  return (
    <nav className=''>
      <div className="@container py-7 px-20 flex justify-between items-center gap-3">
        {/** Logo Section */}
        <div>
          <h1 className='font-bold text-2xl'>ITI Papers</h1>
        </div>
        {/*Menu Section */}
        <div className='hidden @lg:block'>
          <ul className='flex items-center gap-3'>
            {NavbarMenu.map((menu) => (
              <li>
                <a href={menu.slug} className='inline-block py-2 px-3'>{menu.name}</a>
              </li>
            ))}
            <button className='primary-btn'>Sign In</button>
          </ul>
        </div>
      </div>
    </nav>
  )
}

export default Header
