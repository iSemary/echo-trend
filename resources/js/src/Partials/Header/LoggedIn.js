import React from "react";
import { Link } from "react-router-dom";
import AxiosConfig from "../../config/AxiosConfig";
import { Token } from "../../Helpers/Authentication/Token";

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
                {user.full_name}
            </Link>
            <button
                className="btn nav-link"
                aria-label="logout"
                type="button"
                onClick={handleLogout}
            >
                Logout
            </button>
        </>
    );
}
