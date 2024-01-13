import React, { useState } from "react";
import { Form, Button, Row, Col, FloatingLabel } from "react-bootstrap";
import { Link } from "react-router-dom";
import loginImage from "../../assets/images/auth-image.jpg";
import newsIcon from "../../assets/images/icons/news-report.png";
const Login = () => {
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");

    const handleLogin = () => {};

    return (
        <div className="login-page">
            <Row>
                <Col md={6}>
                    <img src={loginImage} className="w-100 login-image" alt="login" />
                </Col>
                <Col md={6}>
                    <Form className="w-75 m-auto" method="POST">
                        <h5>
                            <img
                                src={newsIcon}
                                className="me-1"
                                width={25}
                                height={25}
                                alt="news icon"
                            />
                            Your Gateway to Timely Updates
                        </h5>
                        <p>
                            Where information meets innovation! Log in to gain
                            exclusive access to breaking news, in-depth
                            articles, and personalized content tailored just for
                            you.{" "}
                        </p>

                        <FloatingLabel
                            controlId="floatingInput"
                            label="Email address"
                            className="mb-3"
                        >
                            <Form.Control
                                type="email"
                                placeholder="name@example.com"
                                value={email}
                                onChange={(e) => setEmail(e.target.value)}
                            />
                        </FloatingLabel>
                        <FloatingLabel
                            controlId="floatingPassword"
                            label="Password"
                        >
                            <Form.Control
                                type="password"
                                placeholder="Password"
                                value={password}
                                onChange={(e) => setPassword(e.target.value)}
                            />
                        </FloatingLabel>

                        <Form.Group className="my-3">
                            <Button
                                variant="primary"
                                className="w-100"
                                onClick={handleLogin}
                            >
                                Login
                            </Button>
                        </Form.Group>

                        <Form.Group className="text-center">
                            Don't have an account?{" "}
                            <Link to="/register" className="text-primary">
                                let's register now!
                            </Link>
                        </Form.Group>
                    </Form>
                </Col>
            </Row>
        </div>
    );
};

export default Login;
