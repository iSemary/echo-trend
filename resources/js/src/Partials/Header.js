import React from "react";
import { Navbar, Nav } from "react-bootstrap";
import { Link } from "react-router-dom";
import logo from "../assets/images/logo.svg";
import { FaFire } from "react-icons/fa6";

const Header = () => {
    return (
        <header>
            <Navbar bg="dark" className="container" variant="dark">
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
                    <Link to="/today" className="nav-link" aria-label="login">
                        Sports
                    </Link>
                    <Link to="/today" className="nav-link" aria-label="login">
                        Economies
                    </Link>
                    <Link to="/today" className="nav-link" aria-label="login">
                        Technologies
                    </Link>
                </Nav>
                <Nav className="ml-auto nav-registration">
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
                </Nav>
            </Navbar>
        </header>
    );
};

export default Header;
