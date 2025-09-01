import React, { useState,useEffect } from 'react'
import { useSelector } from 'react-redux'
import { useNavigate } from 'react-router-dom'

function Protected({children,authentication=true}) {
  const authStatus = useSelector((state)=>state.auth.status)
  const navigate = useNavigate();
  const [loader,setLoader] = useState(true);

  useEffect(() => {
    //dash-board auth = true , false
    if(authentication && authStatus!==authentication){
      navigate('/')
    }else if(!authentication && authStatus!==authentication){
      navigate('/dashboard')
    }
    setLoader(false)
  },[authStatus,loader,authentication])

  return loader ? '<h1>Loading...</h1>' : <>{children}</>
}

export default Protected
