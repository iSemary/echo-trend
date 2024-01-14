import React, { useState } from "react";
import { Form, Button, Row, Col, FloatingLabel } from "react-bootstrap";
import { Link } from "react-router-dom";
import loginImage from "../../assets/images/auth-image.jpg";
import newsIcon from "../../assets/images/icons/news-report.png";
import AxiosConfig from "../../config/AxiosConfig";
import { CgSpinnerTwoAlt } from "react-icons/cg";
import { ToastContainer, ToastAlert } from "../../Helpers/Alerts/ToastAlert";
import { Token } from "../../Helpers/Authentication/Token";

const Login = () => {
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [loading, setLoading] = useState(false);
    /** Handle the login functionality */
    const handleLogin = (e) => {
        e.preventDefault();
        setLoading(true);
        AxiosConfig
            .post("/auth/login", { email: email, password: password })
            .then((response) => {
                clearForm();
                setLoading(false);
                // Save the token in the cookies
                Token.store(response.data.data.user.access_token);
                // Show success alert
                ToastAlert(response.data.message, "success");
                // Redirect to home page
            })
            .catch((error) => {
                setLoading(false);
                // Show error message from the api
                if (
                    error.response &&
                    error.response.data &&
                    error.response.data.message
                ) {
                    ToastAlert(error.response.data.message, "error");
                }
                console.error(error);
            });
    };

    /** Clear form input */
    const clearForm = () => {
        setPassword("");
        setEmail("");
    };

    return (
        <div className="login-page">
            <ToastContainer />
            <Row>
                <Col md={6}>
                    <img
                        src={loginImage}
                        className="w-100 login-image"
                        alt="login"
                    />
                </Col>
                <Col md={6}>
                    <Form
                        className="w-75 m-auto"
                        method="POST"
                        onSubmit={handleLogin}
                    >
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
                                disabled={loading ? "disabled" : ""}
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
                                disabled={loading ? "disabled" : ""}
                                placeholder="Password"
                                value={password}
                                onChange={(e) => setPassword(e.target.value)}
                            />
                        </FloatingLabel>

                        <Form.Group className="my-3">
                            <Button
                                variant="primary"
                                className="w-100"
                                type="submit"
                                disabled={loading ? "disabled" : ""}
                            >
                                {loading ? (
                                    <CgSpinnerTwoAlt className="spin-icon" />
                                ) : (
                                    "Login"
                                )}
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
