import React, { useState } from "react";
import {
  Avatar,
  Menu,
  MenuItem,
  IconButton,
  Divider,
  ListItemIcon,
} from "@mui/material";
import Logout from "@mui/icons-material/Logout";
import Person from "@mui/icons-material/Person";
import { useSelector } from "react-redux";
import { amber } from "@mui/material/colors";

function ProfileMenu({ onLogout, onProfile }) {
  const [anchorEl, setAnchorEl] = useState(null);
  const open = Boolean(anchorEl);
  const userData = useSelector((state) => state.auth.userData);

  const profilePic = userData?.profile_picture
    ? `${import.meta.env.VITE_API_URL}/storage/${userData.profile_picture}`
    : "/default.jpg";

  const handleClick = (event) => {
    setAnchorEl(event.currentTarget);
  };

  const handleClose = () => {
    setAnchorEl(null);
  };

  const handleProfile = () => {
    handleClose();
    onProfile();
  };

  const handleLogout = () => {
    handleClose();
    onLogout();
  };

  return (
    <div>
      <IconButton
        onClick={handleClick}
        size="small"
        sx={{
          ml: 2,
          color: amber[700],
          "&:hover": {
            backgroundColor: amber[100],
          },
        }}
        aria-controls={open ? "account-menu" : undefined}
        aria-haspopup="true"
        aria-expanded={open ? "true" : undefined}
      >
        <Avatar
          sx={{
            width: 32,
            height: 32,
            bgcolor: amber[500],
            color: "white",
            fontWeight: 500,
          }}
          src={profilePic}
        >
          {userData?.name?.[0] || "U"}
        </Avatar>
      </IconButton>

      <Menu
        anchorEl={anchorEl}
        id="account-menu"
        open={open}
        onClose={handleClose}
        PaperProps={{
          elevation: 4,
          sx: {
            mt: 1.5,
            minWidth: 180,
            borderRadius: 2,
            backgroundColor: amber[50],
            "& .MuiMenuItem-root": {
              "&:hover": {
                backgroundColor: amber[100],
              },
            },
          },
        }}
        transformOrigin={{ horizontal: "right", vertical: "top" }}
        anchorOrigin={{ horizontal: "right", vertical: "bottom" }}
      >
        <MenuItem onClick={handleProfile}>
          <ListItemIcon>
            <Person fontSize="small" sx={{ color: amber[700] }} />
          </ListItemIcon>
          Profile
        </MenuItem>
        <Divider sx={{ borderColor: amber[200] }} />
        <MenuItem onClick={handleLogout}>
          <ListItemIcon>
            <Logout fontSize="small" sx={{ color: amber[700] }} />
          </ListItemIcon>
          Logout
        </MenuItem>
      </Menu>
    </div>
  );
}

export default ProfileMenu;
