import api from '../utils/api';

export const getProfile = async () => {
    return api.get('/student/profile');
}

export const updateProfile = async (data)=>{
    return api.post('/student/update-profile',data);
}