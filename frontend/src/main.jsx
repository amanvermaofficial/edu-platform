import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import './index.css'
import App from './App.jsx'
import { createBrowserRouter, createRoutesFromElements, RouterProvider, Route } from 'react-router-dom'
import Home from './components/Home/Home.jsx'
import About from './components/About/About.jsx'
import Courses from './components/Courses/Courses.jsx'
import store from './store/store.js'
import Quiz from './components/Quiz/Quiz.jsx'
import AuthLayout from './components/AuthLayout.jsx'
import { Provider } from 'react-redux'
import Dashboard from './components/Dashboard.jsx'

const router = createBrowserRouter([
  {
    path: '/',
    element: <App />,
    children: [
      { path: '/', element: <Home /> },
      { path: "/about", element: (<About />) },
      { path: "/quiz", element: (<Quiz />) },
      { path: "/courses", element: (<Courses />) },
      {
        path: '/dashboard',
        element: (
          <AuthLayout authentication={true}>
            <Dashboard />
          </AuthLayout>
        )
      },
    ]
  }
])

createRoot(document.getElementById('root')).render(
  <StrictMode>
    <Provider store={store}>
      <RouterProvider router={router} />
    </Provider>
  </StrictMode>,
)
