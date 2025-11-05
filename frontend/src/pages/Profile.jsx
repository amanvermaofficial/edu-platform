import React, { useState } from "react";
import { Card, CardContent } from "@mui/material";
import { Avatar, Button } from "@mui/material";
import { useSelector } from "react-redux";
import { Edit } from "@mui/icons-material";
import ProfileModal from "../components/Profile/ProfileModal";

function Profile() {
  const { userData, status } = useSelector((state) => state.auth || {});
  const [open, setOpen] = useState(false);

  if (!userData)
    return (
      <div className="flex flex-col justify-center items-center h-[80vh] space-y-4 bg-amber-50">
        <div className="h-12 w-12 rounded-full bg-amber-500 animate-pulse"></div>
        <p className="text-amber-700 text-lg animate-pulse">Loading profile...</p>
      </div>
    );

  if (!status)
    return (
      <div className="flex justify-center items-center h-screen bg-amber-50 text-gray-600">
        No profile data found.
      </div>
    );

  const profilePic = userData.profile_picture
    ? `${import.meta.env.VITE_API_URL}/storage/${userData.profile_picture}`
    : "/default.jpg";

  return (
    <div className="pt-20 px-6 md:px-20 min-h-screen bg-gradient-to-br from-amber-50 via-white to-amber-100">
      <Card className="max-w-4xl mx-auto shadow-xl rounded-2xl border border-amber-200 bg-white transition-transform duration-300 hover:scale-[1.01]">
        <CardContent className="p-8">
          {/* Header */}
          <div className="flex flex-col md:flex-row items-center md:items-start gap-6">
            <Avatar
              src={profilePic}
              alt={userData.name || ""}
              sx={{
                width: 120,
                height: 120,
                border: "3px solid #f59e0b",
                backgroundColor: "#fbbf24",
              }}
            />
            <div className="flex-1 text-center md:text-left">
              <h1 className="text-3xl font-bold text-amber-700">
                {userData.name || "Unknown User"}
              </h1>
              <p className="text-gray-600">{userData.email}</p>
              <p className="text-gray-600 mt-1">+91 {userData.phone || "No phone number"}</p>

              <div className="flex justify-center md:justify-start mt-4">
                <Button
                  variant="contained"
                  startIcon={<Edit />}
                  sx={{
                    backgroundColor: "#f59e0b",
                    "&:hover": { backgroundColor: "#d97706" },
                  }}
                  className="rounded-full shadow-md"
                  onClick={() => setOpen(true)}
                >
                  Edit Profile
                </Button>
              </div>
            </div>
          </div>

          <hr className="my-8 border-amber-100" />

          {/* Details Section */}
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            <InfoCard label="Trade" value={userData.trade?.name || "—"} />
            <InfoCard label="Gender" value={userData.gender || "—"} />
            <InfoCard label="State" value={userData.state || "—"} />
            <InfoCard label="District" value={userData.district || "—"} />
          </div>

          <div className="mt-10 text-center text-sm text-gray-500">
            Joined on{" "}
            <span className="font-medium text-amber-700">
              {userData.created_at
                ? new Date(userData.created_at).toLocaleDateString()
                : "—"}
            </span>
          </div>
        </CardContent>
      </Card>

      <ProfileModal open={open} onClose={() => setOpen(false)} defaultValues={userData} />
    </div>
  );
}

function InfoCard({ label, value }) {
  return (
    <div className="p-4 bg-amber-50 rounded-xl border border-amber-200 shadow-sm hover:shadow-md transition duration-300">
      <h3 className="text-sm text-amber-700 font-medium">{label}</h3>
      <p className="text-lg font-semibold text-gray-800 mt-1">{value}</p>
    </div>
  );
}

export default Profile;
