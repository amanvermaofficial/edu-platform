import React from 'react'
import {useForm} from 'react-hook-form'
import Input from '../Input'
function SendOtpForm({onSend,loading,error }){
  const {register,handleSubmit,formState:{errors}} = useForm();

  const onSubmit = (data) => {
    onSend(data.phone)
  }
  return (
    <div>
      <form onSubmit={handleSubmit(onSubmit)}  className="max-w-sm mx-auto p-6 bg-white shadow-md rounded-lg space-y-4">
        <div>
           <Input 
              type="text"
              label="Phone Number"
              placeholder="Enter your phone number"
              className={errors.phone ? "border-red-500" : ""}
              {...register("phone",{
                required:"Phone number is required",
                pattern:{
                    value:/^[0-9]{10}$/,
                    message:"Phone number must be 10 digits"
                },
              })}
           /> 
           {errors.phone && (<p className="text-red-500">{errors.phone.message}</p>) }
        </div>

        <button type='submit' disabled={loading} className={`w-full py-2 text-white rounded-md ${loading ? "bg-gray-400 cursor-not-allowed" : "bg-blue-600 hover:bg-blue-700"}`}>
            {loading ? "Sending..." : "Send Otp"}
        </button>

        {error && <p className="text-sm text-red-500">{error}</p>}
      </form>
    </div>
  )
}

export default SendOtpForm
