import React from 'react'
import CircularProgress from '@mui/material/CircularProgress'
import Box from '@mui/material/Box'
function Loading({size=50,message='Loading...'}) {
  return (
    <Box
     sx={{
        display:'flex',
        flexDirection:'column',
        alignItems:'center',
        justifyContent:'center',
        height:'100%',
        padding:20
     }}
    >
        <CircularProgress size={size} color='primary' />
        <p  style={{ marginTop: "10px", color: "#555", fontWeight: 500 }}>{message}</p>
    </Box>
  )
}

export default Loading
