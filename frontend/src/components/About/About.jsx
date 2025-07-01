import React from 'react';
import founderImage from '../../assets/founder.jpeg'; 

function About() {
    return (
        <section className="bg-white py-16 px-4 sm:px-6 lg:px-8 text-gray-800">
            <div className="max-w-4xl mx-auto">
                {/* Header */}
                <div className="text-center mb-12">
                    <h1 className="text-4xl sm:text-5xl font-extrabold text-gray-500 text-start">About EduPlatform</h1>
                    <p className="mt-4 text-lg text-gray-600 text-justify">
                        Your smart companion for exam preparation. Learn smarter, not harder.
                    </p>
                </div>

                {/* Mission */}
                <div className="mb-12">
                    <h2 className="text-2xl font-semibold text-gray-500 mb-3 text-start">🎯 Our Mission</h2>
                    <p className="text-gray-700 leading-relaxed text-justify">
                        At EduPlatform, our mission is clear — to democratize access to quality education using intuitive technology, interactive tools, and a student-first experience. We aim to empower learners with personalized learning journeys that drive real results.
                    </p>
                </div>

                {/* Founder Section */}
                <div className="mb-16 grid grid-cols-1 sm:grid-cols-3 items-center gap-8">
                    <img
                        src={founderImage}
                        alt="Aman Verma - Founder"
                        className="w-48 h-48 sm:w-40 sm:h-48 rounded-xl object-cover shadow-lg mx-auto sm:mx-0   rounded-full object-cover mx-auto sm:mx-0 shadow-md transition-all duration-500 ease-in-out hover:scale-105 hover:shadow-2xl hover:brightness-105 hover:rotate-1"
                    />
                    <div className="sm:col-span-2">
                        <h2 className="text-2xl font-semibold text-gray-500 mb-2 text-start">👨‍🏫 Meet the Founder</h2>
                        <p className="text-gray-700 leading-relaxed text-justify">
                            <strong>Aman Verma</strong> is an educator, creator, and tech enthusiast. With a vision to make smart education available for all, Aman started EduPlatform to bridge the gap between traditional teaching and digital transformation. His goal is simple: help students succeed with tools they actually enjoy using.
                        </p>
                    </div>
                </div>

                {/* Highlights Section */}
                <div className="mb-16">
                    <h2 className="text-2xl font-semibold text-gray-500 mb-4">🚀 Platform Highlights</h2>
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-6 text-gray-700">
                        <div className="p-4 bg-gray-50 rounded-lg shadow-sm">
                            <h3 className="text-lg font-semibold mb-1">🎓 1000+ Students Reached</h3>
                            <p>Trusted by learners across the country to ace competitive exams.</p>
                        </div>
                        <div className="p-4 bg-gray-50 rounded-lg shadow-sm">
                            <h3 className="text-lg font-semibold mb-1">📝 300+ Mock Tests</h3>
                            <p>Practice with full-length and topic-wise mock tests for all levels.</p>
                        </div>
                        <div className="p-4 bg-gray-50 rounded-lg shadow-sm">
                            <h3 className="text-lg font-semibold mb-1">📊 Personalized Dashboards</h3>
                            <p>Smart analytics and feedback to track your learning journey.</p>
                        </div>
                        <div className="p-4 bg-gray-50 rounded-lg shadow-sm">
                            <h3 className="text-lg font-semibold mb-1">📱 Learn Anytime, Anywhere</h3>
                            <p>Fully mobile-friendly — study on your terms, anytime you want.</p>
                        </div>
                    </div>
                </div>

                {/* Contact */}
                <div className="text-center">
                    <h2 className="text-2xl font-semibold text-gray-500 mb-3">📞 Get in Touch</h2>
                    <p className="text-gray-700 mb-2">
                        Have questions, feedback, or want to collaborate?
                    </p>
                    <p className="text-gray-700">
                        ✉️ <a href="mailto:amn.lohaniwal@gmail.com" className="text-blue-600 underline">amn.lohaniwal@gmail.com</a>
                        <br />
                        📲 <a href="https://t.me/itipapersyt" className="text-blue-600 underline" target="_blank" rel="noopener noreferrer">Join our Telegram Community</a>
                    </p>
                </div>
            </div>
        </section>
    );
}

export default About;
