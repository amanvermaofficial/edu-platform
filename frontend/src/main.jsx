import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import './index.css'
import App from './App.jsx'
import { createBrowserRouter, createRoutesFromElements, RouterProvider, Route } from 'react-router-dom'
import Home from './components/Home/Home.jsx'
import About from './components/About/About.jsx'
import Courses from './components/Courses/Courses.jsx'
import store from './store/store.js'
import AuthLayout from './components/AuthLayout.jsx'
import { Provider } from 'react-redux'
import Dashboard from './components/Dashboard.jsx'
import Trades from './components/Trades/trades.jsx'
import QuizList from './components/Quiz/QuizList.jsx'
import QuizAttempt from './components/Quiz/QuizAttempt.jsx'
import QuizResult from './components/Quiz/QuizResult.jsx'
import Profile from './pages/Profile.jsx'
// index.js or main.jsx
import "nprogress/nprogress.css";
import GoogleLogin from './components/GoogleLogin.jsx'
import AuthSuccess from './pages/AuthSuccess.jsx'
import QuizResultReview from './components/Quiz/QuizResultReview.jsx'


const router = createBrowserRouter([
  {
    path: '/',
    element: <App />,
    children: [
      { path: '/', element: <Home /> },
      { path: "/about", element: (<About />) },
      { path: "/courses", element: (<Courses />) },
      {
        path: '/login',
        element: (
          <AuthLayout authentication={false}>
            <GoogleLogin />
          </AuthLayout>
        )
      },
      {
        path: 'auth/success',
        element: (
          <AuthLayout authentication={false}>
            <AuthSuccess />
          </AuthLayout>
        )
      },
      {
        path: '/dashboard',
        element: (
          <AuthLayout authentication={true}>
            <Dashboard />
          </AuthLayout>
        )
      },
      {
        path: '/profile',
        element: (
          <AuthLayout authentication={true}>
            <Profile />
          </AuthLayout>
        )
      },
      {
        path:'/courses/:id/trades',
        element:(
          <AuthLayout authentication={true}>
            <Trades />
          </AuthLayout>
        )
      },
      {
        path:'/courses/:courseId/trades/:tradeId/quizzes',
        element:(
          <AuthLayout authentication={true}>
            <QuizList />
          </AuthLayout>
        )
      },
      {
        path:'/courses/:courseId/trades/:tradeId/quizzes/:quizId/attempt',
        element:(
          <AuthLayout authentication={true}>
            <QuizAttempt />
          </AuthLayout>
        )
      },
      {
        path:'/quiz-result/:quizId',
        element:(
          <AuthLayout authentication={true}>
            <QuizResult />
          </AuthLayout>
        )
      },
      {
        path:'/quiz-result/:quizId/result-review',
        element:(
          <AuthLayout authentication={true}>
            <QuizResultReview />
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
