import api from "../utils/api";

export const getTestimonials = async () => {
    return api.get("/testimonials");
};

export const addTestimonial = async (data) => {
    return api.post("/reviews", data);
};