import React from "react";
import { Container, Row, Col, Button } from "react-bootstrap";
import { Link } from "react-router-dom";

const NotFound = () => {
    return (
        <Container className="not-found-container">
            <Row className="justify-content-center align-items-center full-height">
                <Col md={6} className="text-center">
                    <h1 className="display-1">404</h1>
                    <h2>Oops! Page not found</h2>
                    <p>
                        The page you are looking for might be in another
                        universe.
                    </p>
                    <Link to="/">
                        <Button variant="primary">Go Home</Button>
                    </Link>
                </Col>
            </Row>
        </Container>
    );
};

export default NotFound;
