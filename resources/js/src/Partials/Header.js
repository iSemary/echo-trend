import React from "react";
import { Navbar, Nav } from "react-bootstrap";
import { Link } from "react-router-dom";

const Header = () => {
    return (
        <Navbar bg="dark" className="container" variant="dark">
            <Link to="/" className="navbar-brand" aria-label="home">
                {process.env.REACT_APP_NAME}
            </Link>
            <Nav className="ml-auto">
                <Link to="/today" className="nav-link" aria-label="login">
                    What happened today
                </Link>
            </Nav>
            <Nav className="ml-auto">
                <Link to="/login" className="nav-link" aria-label="login">
                    Login
                </Link>
            </Nav>
        </Navbar>
    );
};

export default Header;
