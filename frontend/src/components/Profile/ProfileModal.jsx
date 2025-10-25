import React, { useEffect, useState } from 'react'
import {
    Dialog,
    DialogTitle,
    DialogContent,
    DialogActions,
    Button,
    MenuItem,
} from "@mui/material";
import { useForm } from 'react-hook-form';
import Input from '../Input';
import { updateProfile } from '../../services/ProfileService'
import { toast } from 'react-toastify';
import Select from '../Select';
import { getTrades } from '../../services/TradeService';
import { useDispatch } from 'react-redux';
import { setUserData } from "../../store/authSlice";


function ProfileModal({ open, onClose, defaultValues }) {
    const { register, reset, handleSubmit, formState: { errors } } = useForm({ defaultValues });
    const [trades, setTrades] = useState([]);
    const dispatch = useDispatch();

    const onSubmit = async (data) => {
        try {
            const formData = new FormData();

            // File handle properly
            if (data.profile_picture instanceof FileList && data.profile_picture.length > 0) {
                formData.append("profile_picture", data.profile_picture[0]);
            }

            // baki saare fields append karo
            formData.append("name", data.name || "");
            formData.append("phone", data.phone || "");
            formData.append("trade_id", data.trade_id || "");
            formData.append("gender", data.gender || "");
            formData.append("email", data.email || "");
            formData.append("state", data.state || "");

           
            const response = await updateProfile(formData);

            if (response.status === 200) {
                toast.success(response.data.message);
                console.log(response.data.data);
                dispatch(setUserData(response.data.data));
                onClose();
                
            }
        } catch (error) {
            toast.error(error.response?.data?.message || "Failed to update profile");
        }
    };

    useEffect(() => {
        console.log("Default values in profile:", defaultValues);
        reset(defaultValues);
    }, [defaultValues, reset]);

    useEffect(() => {
        async function fetchTrades() {
            try {
                const res = await getTrades();
                setTrades(res.data.data.trades);
            } catch (error) {
                toast.error("Failed to load trades");
            }
        }

        fetchTrades();
    }, []);

    return (
        <Dialog open={open} onClose={onClose} fullWidth maxWidth="sm">
            <DialogTitle>Update Profile</DialogTitle>
            <DialogContent dividers>
                <form onSubmit={handleSubmit(onSubmit)}>
                    <Input
                        label="Profile Picture"
                        className="mb-4"
                        accept="image/*"
                        type="file"
                        {...register("profile_picture")}
                    />

                    <Input label="Name" className="mb-4" placeholder="Enter your name" {...register("name", { required: "Name is required" })} />
                    {errors.name && (<p className="text-red-500">{errors.name.message}</p>)}

                    <Input label="Email" className="mb-4" type="email" placeholder="Enter your email" {...register("email", { required: "Email is required" })} />
                    {errors.email && (<p className="text-red-500">{errors.email.message}</p>)}

                    <Input label="Phone Number" className="mb-4" placeholder="Enter your phone number" {...register("phone", { required: "Phone number is required" })} />
                    {errors.phone_number && (<p className="text-red-500">{errors.phone_number.message}</p>)}

                    <Select label='Trade' className="mb-4"  {...register("trade_id", { required: "Trade is required" })}>
                        <option value="">Select Trade</option>
                        {trades.map((trade) => (
                            <option key={trade.id} value={trade.id}>
                                {trade.name}
                            </option>
                        ))}
                    </Select>
                    {errors.trade_id && (
                        <p className="text-red-500 text-sm">{errors.trade_id.message}</p>
                    )}
                    <Select
                        label="Gender"
                        {...register("gender", { required: "Gender is required" })}
                    >
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </Select>
                    {errors.gender && (
                        <p className="text-red-500 text-sm">{errors.gender.message}</p>
                    )}


                    <Input
                        label="State"
                        {...register("state", { required: "State is required" })}
                    />
                    {errors.state && (
                        <p className="text-red-500 text-sm">{errors.state.message}</p>
                    )}

                    <DialogActions>
                        <Button onClick={onClose} color="secondary">
                            Cancel
                        </Button>
                        <Button type="submit" className='primary-btn' variant="contained">
                            Save
                        </Button>
                    </DialogActions>
                </form>
            </DialogContent>

        </Dialog>
    )
}

export default ProfileModal
