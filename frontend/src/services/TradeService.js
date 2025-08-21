import api from "../utils/api"; 

export const getTrades = async () => {
    return api.get('/trades');
}