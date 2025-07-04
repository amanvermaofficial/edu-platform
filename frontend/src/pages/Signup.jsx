import React, { useState } from 'react'
import { useForm } from 'react-hook-form'
import Input from '../components/Input'
import auth from '../assets/images/auth1.png'

function Signup() {
    const { register, handleSubmit, formState: { errors } } = useForm()
    return (
        <div className='min-h-screen flex'>
            <div className="w-1/2 bg-blue-100 hidden lg:flex items-center justify-center">
                <img
                    src={auth} alt="Signup visual" className='max-w-md' />
            </div>

            <div className='w-full lg:w-1/2 flex items-center justify-center px-6 py-12'>
                <form className="w-full max-w-md space-y-5 bg-white p-8 rounded-lg shadow-md">
                    <h2 className="text-2xl font-bpld mb-4 text-center">Create Your Account</h2>


                    <div>
                        <Input label="Name" {...register("name", { required: "Name is required." })} />
                        {
                            errors.name && (
                                <p className='text-red-600 text-sm'>{errors.name.message}</p>
                            )
                        }
                    </div>

                    <div>
                        <Input
                            label="Email"
                            type="email"
                            {...register("email", {
                                required: "Email is required",
                                pattern: {
                                    value: /^\S+@\S+$/,
                                    message: "Invalid email address",
                                },
                            })}
                        />

                        {errors.email && (
                            <p className="text-red-500 text-sm mt-1">{errors.email.message}</p>
                        )}
                    </div>

                    <div>
                        <Input
                            label="Password"
                            type="password"
                            {...register("password", {
                                required: "Password is required",
                                minLength: {
                                    value: 6,
                                    message: "Password must be at least 6 characters",
                                },
                            })}
                        />
                        {errors.password && (
                            <p className="text-red-500 text-sm mt-1">
                                {errors.password.message}
                            </p>
                        )}
                    </div>

                    <button
                        type="submit"
                        className="w-full primary-btn text-white py-2 rounded transition"
                    >
                        Sign Up
                    </button>
                </form>
            </div>
        </div>
    )
}

export default Signup
