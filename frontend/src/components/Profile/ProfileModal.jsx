import React, { useEffect, useState } from 'react'
import {
    Dialog,
    DialogTitle,
    DialogContent,
    DialogActions,
    Button,
    MenuItem,
    Avatar,
    IconButton
} from "@mui/material";
import PhotoCameraIcon from '@mui/icons-material/PhotoCamera';
import { useForm } from 'react-hook-form';
import Input from '../Input';
import { updateProfile } from '../../services/ProfileService'
import { toast } from 'react-toastify';
import Select from '../Select';
import { getTrades } from '../../services/TradeService';
import { useDispatch } from 'react-redux';
import { setUserData } from "../../store/authSlice";
import { Controller } from 'react-hook-form';


function ProfileModal({ open, onClose, defaultValues }) {
    const { register, reset, handleSubmit, control, formState: { errors } } = useForm({ defaultValues });
    const [trades, setTrades] = useState([]);
      const [preview, setPreview] = useState(defaultValues?.profile_picture || null);
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

       const handleImageChange = (e) => {
        const file = e.target.files[0];
        if (file) {
            setPreview(URL.createObjectURL(file));
        }
    };
    return (
        <Dialog open={open} onClose={onClose} fullWidth maxWidth="sm">
            <DialogTitle>Update Profile</DialogTitle>
            <DialogContent dividers>
                <form onSubmit={handleSubmit(onSubmit)}>
                      <div className="flex flex-col items-center mb-6">
                        <Avatar
                            src={preview}
                            alt=""
                            sx={{ width: 100, height: 100, marginBottom: 1 }}
                        />
                        <input
                            accept="image/*"
                            id="profile-upload"
                            type="file"
                            style={{ display: "none" }}
                            {...register("profile_picture")}
                            onChange={(e) => {
                                handleImageChange(e);
                                register("profile_picture").onChange(e);
                            }}
                        />
                        <label htmlFor="profile-upload">
                            <IconButton
                                component="span"
                                sx={{
                                    backgroundColor: "#f3f4f6",
                                    "&:hover": { backgroundColor: "#e5e7eb" },
                                }}
                            >
                                <PhotoCameraIcon />
                            </IconButton>
                        </label>
                    </div>


                    <Input label="Name" className="mb-4" placeholder="Enter your name" {...register("name", { required: "Name is required", pattern: { value: /^[A-Za-z\s]+$/, message: 'Invalid name' } })} />
                    {errors.name && (<p className="text-red-500">{errors.name.message}</p>)}

                    <Input label="Email" className="mb-4" type="email" placeholder="Enter your email" {...register("email", {
                        required: "Email is required", pattern: {
                            value: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                            message: "Enter a valid email address",
                        },
                    })} />
                    {errors.email && (<p className="text-red-500">{errors.email.message}</p>)}

                    <Input label="Phone Number" className="mb-4" placeholder="Enter your phone number" {...register("phone", {
                        required: "Phone number is required",
                        pattern: {
                            value: /^[0-9]+$/,
                            message: "Phone number should contain only digits",
                        },
                        minLength: {
                            value: 10,
                            message: "Phone number must be 10 digits",
                        },
                        maxLength: {
                            value: 10,
                            message: "Phone number must be 10 digits",
                        },
                    })} />
                    {errors.phone && (<p className="text-red-500">{errors.phone.message}</p>)}

                    <Controller
                        name='trade_id'
                        control={control}
                        rules={{ required: 'Trade is required' }}
                        render={({ field }) => (
                            <Select label='Trade' className="mb-4" {...field}>
                                <option value="">Select Trade</option>
                                {trades.map((trade) => (
                                    <option key={trade.id} value={trade.id}>
                                        {trade.name}
                                    </option>
                                ))}
                            </Select>
                        )}
                    />

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
                        {...register("state", { required: "State is required",
                         minLength: { value: 2, message: "State name too short" },
                         })}
                    />
                    {errors.state && (
                        <p className="text-red-500 text-sm">{errors.state.message}</p>
                    )}

                    <DialogActions>
                        <Button onClick={onClose}
                            variant="outlined"
                            sx={{
                                color: "#000",
                                borderColor: "#000",
                                "&:hover": {
                                    backgroundColor: "#000",
                                    color: "#fff",
                                },
                            }}
                        >
                            Cancel
                        </Button>
                        <Button type="submit" variant="contained"
                            sx={{
                                backgroundColor: "#f59e0b",
                                "&:hover": {
                                    backgroundColor: "#d97706",
                                },
                            }}>
                            Save
                        </Button>
                    </DialogActions>
                </form>
            </DialogContent>

        </Dialog>
    )
}

export default ProfileModal
