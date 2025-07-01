import React from 'react'
import Header from '../Header/Header'
import { IoIosArrowRoundForward } from "react-icons/io";
import heroImage from '../../assets/hero.png'
import { animate, motion } from "framer-motion"
import Courses from '../Courses/Courses';


export const FadeUp = (delay) => {
    return {
        initial: {
            opacity: 0,
            y: 50,
        },
        animate: {
            opacity: 1,
            y: 0,
            transition: {
                type: "spring",
                stiffness: 100,
                duration: 0.5,
                delay: delay,
                ease: "easeInOut"
            }
        }
    }
}

function Home() {
    return (
        <section className='bg-light overflow-hidden relative'>
            <Header />
            <div className='flex justify-center items-center flex-col lg:flex-row bg-gray'>

                <div className='max-w-3xl flex flex-col justify-center py-10 xl:py-0'>
                    <div className='text-center px-3'>
                        <motion.h1
                            variants={FadeUp(0.6)}
                            initial="initial"
                            animate="animate"
                            className=' text-center text-2xl md:text-3xl lg:text-5xl font-bold leading-snug'>
                            <span className='text-green-500 underline'>Learn</span> Smart. <span className='text-green-500 underline'>Grow</span> Fast.
                        </motion.h1>
                        <motion.p
                            variants={FadeUp(0.8)}
                            initial="initial"
                            animate="animate"
                            className='text-gray-400 px-2 text-sm md:text-lg'>An all-in-one learning platform offering mock tests, video lessons, and progress tracking — designed to make exam preparation easier, faster, and more effective.
                        </motion.p>
                        <motion.div
                            variants={FadeUp(1)}
                            initial="initial"
                            animate="animate"
                            className='flex justify-center mt-2'>
                            <button className='primary-btn flex justify-center items-center gap-2 group'>
                                Get Start
                                <IoIosArrowRoundForward className='text-xl group-hover:translate-x-2 group-hover:-rotate-45 duration-300' />
                            </button>
                        </motion.div>
                    </div>
                </div>
                <div>
                    <motion.img
                        initial={{ x: 50, opacity: 0 }}
                        animate={{ x: 0, opacity: 1 }}
                        transition={{ duration: 0.6, delay: 0.4, ease: "easeInOut" }}
                        src={heroImage} alt="" className='w-[370px] md:w-[500px] lg:w-[600px]' />
                </div>
            </div>
              <Courses/>
        </section>
    )
}

export default Home
