import React from 'react';
import fashionImg from '../../assets/images/fashion.jpg';
import { MdOutlineArrowOutward } from "react-icons/md";
import { animate, motion } from 'framer-motion';

function Courses() {
    const courseData = [
        {
            id: 1,
            title: "F D & T Mock Class",
            img: fashionImg,
        },
        {
            id: 2,
            title: "Gold Facial Training",
            img: "https://images.herzindagi.info/image/2022/Apr/gold-facial-cost-procedure-how-to-do.jpg"
        },
        {
            id: 3,
            title: "Women Empowerment Class",
            img: "https://www.csrmandate.org/wp-content/uploads/2023/09/image.png"
        }
    ];

    return (
        <section>
            <div className='p-4 mt-5 max-w-[1300px] mx-auto my-0'>
                <div className='flex items-center justify-between mb-5'>
                    <div>
                        <h1 className='text-start text-[27px] lg:text-4xl font-bold'>Our Courses</h1>
                        <p className='text-gray-400 text-[13px] lg:text-lg text-start'>
                            Lorem Ipsum is simply dummy text of the prininting
                        </p>
                    </div>
                    <div className='text-sm'>
                        <a href="#">
                            <div className='flex items-center gap-[2px] underline'>
                                <p>Explore More courses</p>
                                <MdOutlineArrowOutward />
                            </div>
                        </a>
                    </div>
                </div>

                {/* Cards Section */}
                <div className='flex justify-center xl:justify-start gap-7 xl:gap-18 flex-wrap md:flex-nowrap'>
                    {courseData.map((course, index) => (
                        <motion.div
                            key={course.id}
                            className="bg-white shadow-md rounded-lg overflow-hidden w-80 max-w-sm"
                            initial={{ scale: 0.9, opacity: 0 }}
                            whileInView={{ scale: 1, opacity: 1 }}
                            transition={{
                                delay: index * 0.2,
                                duration: 0.9,
                                ease: [0.25, 0.1, 0.25, 1]
                            }}
                            viewport={{ once: true, amount: 0.3 }} // triggers only once, 30% in view
                        >
                            <img src={course.img} alt="" className="w-full h-52 object-cover" />
                            <div className="p-4">
                                <div className="flex items-center justify-between mt-2 mb-4">
                                    <span className="text-orange-500 text-lg font-semibold">Free</span>
                                    <h3 className="text-lg font-semibold text-gray-800">{course.title}</h3>
                                </div>
                                <button className="primary-btn w-full">
                                    Enroll Now
                                </button>
                            </div>
                        </motion.div>
                    ))}
                </div>
            </div>
        </section>
    );
}

export default Courses;
