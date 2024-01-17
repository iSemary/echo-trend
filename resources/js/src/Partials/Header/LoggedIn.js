import React from "react";
import { Link } from "react-router-dom";
import AxiosConfig from "../../config/AxiosConfig";
import { Token } from "../../Helpers/Authentication/Token";
import { CgProfile } from "react-icons/cg";
import { FiLogOut } from "react-icons/fi";

export default function LoggedIn({ user, setSession }) {
    const CURRENT_SESSION = 1;
    const handleLogout = () => {
        AxiosConfig.post("/auth/logout", { type: CURRENT_SESSION })
            .then(() => {
                setSession(3);
                Token.explode();
            })
            .catch((error) => console.error(error));
    };
    return (
        <>
            <Link to="/profile" className="nav-link" aria-label="profile">
                <CgProfile className="mb-1" size={20} /> {user.full_name}
            </Link>
            <button
                className="btn nav-link"
                aria-label="logout"
                type="button"
                onClick={handleLogout}
            >
                <FiLogOut className="mb-1" size={20} /> Logout
            </button>
        </>
    );
}
