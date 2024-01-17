import React, { useEffect, useState } from "react";
import { Navbar, Nav } from "react-bootstrap";
import { Link } from "react-router-dom";
import logo from "../assets/images/logo.svg";
import { FaFire } from "react-icons/fa6";
import { CgSpinnerTwoAlt } from "react-icons/cg";
import { SearchContainer } from "../Helpers/Search/SearchContainer";
import { FaSearch } from "react-icons/fa";
import LoggedIn from "./Header/LoggedIn";
import LoggedOut from "./Header/LoggedOut";

const Header = ({ user, loadingUser, categories, sources }) => {
    const [showSearchBar, setShowSearchBar] = useState(false);
    const [session, setSession] = useState(1);

    useEffect(() => {
        if (loadingUser) {
            setSession(1);
        } else {
            if (user) {
                setSession(2);
            } else {
                setSession(3);
            }
        }
    }, [loadingUser, user]);

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
                    {session === 1 ? (
                        <CgSpinnerTwoAlt className="spin-icon my-3" />
                    ) : session === 2 ? (
                        <LoggedIn user={user} setSession={setSession} />
                    ) : (
                        <LoggedOut />
                    )}
                </Nav>
            </Navbar>

            <SearchContainer
                categories={categories}
                sources={sources}
                show={showSearchBar}
            />
        </header>
    );
};

export default Header;
