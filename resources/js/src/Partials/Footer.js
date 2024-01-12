import React from "react";
import { Container, Row, Col } from "react-bootstrap";

const Footer = () => {
    return (
        <footer className="mt-5">
            <Container>
                <Row>
                    <Col>
                        <p>
                            &copy; 2024 {process.env.REACT_APP_NAME}. All rights
                            reserved.
                        </p>
                    </Col>
                </Row>
            </Container>
        </footer>
    );
};

export default Footer;
