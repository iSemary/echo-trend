import React from "react";
import { Navbar, Nav } from "react-bootstrap";

const Header = () => {
    return (
        <Navbar bg="dark" variant="dark">
            <Navbar.Brand href="#home">
                {process.env.REACT_APP_NAME}
            </Navbar.Brand>
            <Nav className="mr-auto">
                <Nav.Link href="#home">Home</Nav.Link>
                <Nav.Link href="#features">Features</Nav.Link>
                <Nav.Link href="#about">About</Nav.Link>
            </Nav>
        </Navbar>
    );
};

export default Header;
