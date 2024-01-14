import React, { useState } from "react";
import { Navbar, Nav } from "react-bootstrap";
import { Link } from "react-router-dom";
import logo from "../assets/images/logo.svg";
import { FaFire } from "react-icons/fa6";
import { CgSpinnerTwoAlt } from "react-icons/cg";
import AxiosConfig from "../config/AxiosConfig";
import { Token } from "../Helpers/Authentication/Token";
import { SearchContainer } from "../Helpers/Search/SearchContainer";
import { FaSearch } from "react-icons/fa";

const Header = ({ user, loadingUser, categories, sources }) => {
    const CURRENT_SESSION = 1;

    const [showSearchBar, setShowSearchBar] = useState(false);

    const handleLogout = () => {
        AxiosConfig.post("/auth/logout", { type: CURRENT_SESSION })
            .then((response) => {
                Token.explode();
            })
            .catch((error) => console.error(error));
    };

    return (
        <header>
            <Navbar className="container" variant="dark">
                <Link to="/" className="navbar-brand" aria-label="home">
                    <img
                        src={logo}
                        className="logo"
                        width="50px"
                        height="50px"
                        alt="site logo"
                    />
                    <span className="date">
                        {new Date().toLocaleDateString("en-US", {
                            day: "numeric",
                            month: "long",
                            year: "numeric",
                        })}
                    </span>
                </Link>
                <Nav className="ml-auto nav-categories">
                    <Link to="/today" className="nav-link" aria-label="login">
                        <FaFire className="mb-1" /> Today
                    </Link>
                    {categories &&
                        categories.length > 0 &&
                        categories.slice(0, 4).map((category, index) => (
                            <Link
                                key={index}
                                to={`/categories/${category.slug}/articles`}
                                className="nav-link"
                                aria-label="login"
                            >
                                {category.title}
                            </Link>
                        ))}
                </Nav>
                <Nav className="ml-auto nav-registration">
                    <button
                        className="nav-link"
                        aria-label="search"
                        type="button"
                        onClick={(e) => setShowSearchBar(!showSearchBar)}
                    >
                        <FaSearch />
                    </button>
                    {loadingUser ? (
                        <CgSpinnerTwoAlt className="spin-icon" />
                    ) : user ? (
                        <>
                            <Link
                                to="/profile"
                                className="nav-link"
                                aria-label="profile"
                            >
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
                    ) : (
                        <>
                            <Link
                                to="/login"
                                className="nav-link"
                                aria-label="login"
                            >
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
                    )}
                </Nav>
            </Navbar>

            <SearchContainer categories={categories} sources={sources} show={showSearchBar} />
        </header>
    );
};

export default Header;
