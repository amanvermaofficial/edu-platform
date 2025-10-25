import api from "../utils/api"; 

export const getTrades = async () => {
    return api.get('/trades');
}

export const getTradesByCourse = async (id) => {
    return api.get(`/courses/${id}/trades`);
}