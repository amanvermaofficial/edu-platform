import api from "../utils/api";

export const getStudentPerformance = async () => {
  return api.get(`/student/performance`); 
};
