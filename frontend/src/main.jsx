import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import './index.css'
import App from './App.jsx'
import {createBrowserRouter, createRoutesFromElements, RouterProvider,Route} from 'react-router-dom'
import Home from './components/Home/Home.jsx'
import About from './components/About/About.jsx'
import Courses from './components/Courses/Courses.jsx'
import Signup from './pages/Signup.jsx'
import AuthLayout from './Layout/AuthLayout.jsx'
import Quiz from './components/Quiz/Quiz.jsx'

const router = createBrowserRouter([
  {
    path:'/',
    element:<App />,
    children:[
      {
        path:'/',
        element:<Home />
      },
      {
        path:"/about",
        element:(
          <About />
        )
      },
      {
        path:"/quiz",
        element:(
          <Quiz />
        )
      },
      {
        path:"/courses",
        element:(
          <Courses />
        )
      }
    ]
  },
  {
    path:"/",
    element:<AuthLayout />,
    children:[
      {path:"signup",element:<Signup/>}
    ]
  }
])

createRoot(document.getElementById('root')).render(
  <StrictMode>
      <RouterProvider router={router} />
  </StrictMode>,
)
