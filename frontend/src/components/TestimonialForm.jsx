import React, { use, useState } from "react";
import { useForm } from "react-hook-form";
import { addTestimonial } from "../services/review";
import { useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";

function TestimonialForm() {
  const {
    register,
    handleSubmit,
    watch,
    reset,
    formState: { errors },
  } = useForm();

  const [loading, setLoading] = useState(false);
 
  const userData = useSelector((state) => state.auth.userData);
  const navigate = useNavigate();

  const descVal = watch("description", "");
  const wordCount = descVal
    ? descVal.trim().split(/\s+/).length
    : 0;

  const onSubmit = async (data) => {
    if(!userData){
      alert("Please login to submit feedback");
      navigate("/login");
      return
    }
    try {
      setLoading(true);
      await addTestimonial(data);
      reset();
      alert("Feedback submitted");
    } catch (err) {
      alert("Something went wrong");
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="bg-gray-50 py-12">
      <form
        onSubmit={handleSubmit(onSubmit)}
        className="max-w-lg mx-auto bg-white p-6 rounded-xl shadow-md"
      >
        {/* Heading */}
        <h2 className="text-2xl font-semibold text-center">
          Add Feedback
        </h2>
        <p className="text-sm text-gray-500 text-center mb-6">
          Share your experience in a few words
        </p>

        {/* Label */}
        <label className="block text-sm font-medium mb-2">
          Description <span className="text-gray-400">(10–500 words)</span>
        </label>

        {/* Textarea */}
        <textarea
          {...register("description", {
            required: "Description is required",
            minLength: {
              value: 10,
              message: "Minimum 10 characters required",
            },
            validate: (value) =>
              value.trim().split(/\s+/).length <= 500 ||
              "Maximum 500 words allowed",
          })}
          rows={5}
          placeholder="Write your honest feedback here..."
          className={`w-full rounded-lg border px-4 py-3 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-amber-400 ${
            errors.description ? "border-red-500" : "border-gray-300"
          }`}
        />

        {/* Counter & Error */}
        <div className="flex justify-between items-center text-xs mt-2">
          <span
            className={`${
              wordCount > 500 ? "text-red-500" : "text-gray-400"
            }`}
          >
            {wordCount} / 500 words
          </span>

          {errors.description && (
            <span className="text-red-500">
              {errors.description.message}
            </span>
          )}
        </div>

        {/* Submit */}
        <button
          type="submit"
          disabled={loading || wordCount > 500}
          className="mt-6 w-full bg-amber-500 hover:bg-amber-600 transition text-white py-3 rounded-lg font-medium disabled:opacity-50"
        >
          {loading ? "Submitting..." : "Submit Feedback"}
        </button>
      </form>
    </div>
  );
}

export default TestimonialForm;
