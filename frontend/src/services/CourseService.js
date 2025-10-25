import api from "../utils/api";

export const getCourses = async () => {
    return api.get('/courses');
}
