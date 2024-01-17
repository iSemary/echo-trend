import React from "react";
import { Link } from "react-router-dom";

export default function LoggedOut() {
    return (
        <>
            <Link to="/login" className="nav-link" aria-label="login">
                Login
            </Link>
            <Link
                to="/register"
                className="nav-link"
                aria-label="create an account"
            >
                Create an account
            </Link>
        </>
    );
}
