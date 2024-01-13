import React, { useState } from "react";
import { Form, Button, FloatingLabel, Col, Row } from "react-bootstrap";
import { Link } from "react-router-dom";
import registerImage from "../../assets/images/auth-image.jpg";
import newsIcon from "../../assets/images/icons/news-report.png";
import Select from "react-select";
import makeAnimated from "react-select/animated";
import styleVariables from "../../assets/styles/variables/variables.module.scss";

const Register = () => {
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");

    // Select2 animation on select
    const animatedComponents = makeAnimated();

    // Categories options
    const options = [
        { value: "chocolate", label: "Chocolate" },
        { value: "strawberry", label: "Strawberry" },
        { value: "vanilla", label: "Vanilla" },
    ];

    const handleRegister = (e) => {
        e.preventDefault();
    };

    return (
        <div className="register-page">
            <Row>
                <Col md={6} className="d-grid align-items-center">
                    <img
                        src={registerImage}
                        className="w-100 login-image"
                        alt="register"
                    />
                </Col>
                <Col md={6}>
                    <Form
                        className="w-75 m-auto"
                        method="POST"
                        onSubmit={handleRegister}
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
                            Become a part of the news community by registering
                            today! Unlock a world of premium content,
                            personalized news feeds, and exclusive features
                            tailored to your interests.
                        </p>

                        <FloatingLabel label="Full Name" className="mb-3">
                            <Form.Control
                                type="text"
                                placeholder=""
                                value={email}
                                onChange={(e) => setEmail(e.target.value)}
                            />
                        </FloatingLabel>

                        <FloatingLabel label="Email address" className="mb-3">
                            <Form.Control
                                type="email"
                                placeholder=""
                                value={email}
                                onChange={(e) => setEmail(e.target.value)}
                            />
                        </FloatingLabel>

                        <FloatingLabel label="Password">
                            <Form.Control
                                type="password"
                                placeholder=""
                                value={password}
                                onChange={(e) => setPassword(e.target.value)}
                            />
                        </FloatingLabel>

                        <Form.Group className="mt-2">
                            <Form.Label>Interests (optional)</Form.Label>
                            <Select
                                closeMenuOnSelect={false}
                                components={animatedComponents}
                                isMulti
                                options={options}
                                theme={(theme) => ({
                                    ...theme,
                                    colors: {
                                        ...theme.colors,
                                        primary25: styleVariables.primaryColor,
                                        primary: styleVariables.primaryColor,
                                        neutral0: styleVariables.darkGrayColor,
                                        neutral10: styleVariables.primaryColor,
                                        neutral80: styleVariables.whiteColor,
                                    },
                                })}
                            />
                        </Form.Group>

                        <Form.Group className="my-3">
                            <Button
                                variant="primary"
                                className="w-100"
                                type="submit"
                            >
                                Create an account
                            </Button>
                        </Form.Group>

                        <Form.Group className="text-center">
                            Already registered?{" "}
                            <Link to="/login" className="text-primary">
                                login now!
                            </Link>
                        </Form.Group>
                    </Form>
                </Col>
            </Row>
        </div>
    );
};

export default Register;
