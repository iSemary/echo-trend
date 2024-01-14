import React, { useEffect, useState } from "react";
import { Form, Button, FloatingLabel, Col, Row } from "react-bootstrap";
import { Link } from "react-router-dom";
import registerImage from "../../assets/images/auth-image.jpg";
import newsIcon from "../../assets/images/icons/news-report.png";
import AxiosConfig from "../../config/AxiosConfig";
import IntlTelInput from "react-intl-tel-input-18";
import "react-intl-tel-input-18/dist/main.css";
import { ToastContainer, ToastAlert } from "../../Helpers/Alerts/ToastAlert";
import { Token } from "../../Helpers/Authentication/Token";
import { CgSpinnerTwoAlt } from "react-icons/cg";
import CustomSelector from "../../Helpers/Utilities/CustomSelector";
import { LuInfo } from "react-icons/lu";

const Register = () => {
    const initialValues = {
        full_name: "",
        email: "",
        phone: "",
        dial_code: "",
        country_code: "",
        password: "",
        password_confirmation: "",
        categories: [],
    };
    const [formValues, setFormValues] = useState(initialValues);
    const [loading, setLoading] = useState(false);
    // Categories options
    const [categories, setCategories] = useState([]);
    /** Change form values states on change inputs based on name and value */
    const handleChangeValues = (e) => {
        const { name, value } = e.target;
        setFormValues({
            ...formValues,
            [name]: value,
        });
    };

    const handleChangePhone = (isValid, value, selectedCountryData) => {
        setFormValues({
            ...formValues,
            phone: value,
            dial_code: selectedCountryData.dialCode,
            country_code: selectedCountryData.iso2,
        });
    };

    const handleChangeInterests = (e) => {
        const selectedIds = e.map((option) => option.id);
        setFormValues({
            ...formValues,
            categories: selectedIds,
        });
    };

    /** create a POST request to register API */
    const handleRegister = (e) => {
        e.preventDefault();
        setLoading(true);

        AxiosConfig.post("/auth/register", formValues)
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

    const clearForm = () => {
        setFormValues(initialValues);
    };

    /** Getting the categories  */
    useEffect(() => {
        AxiosConfig.get("/categories").then((response) => {
            setCategories(response.data.data.categories);
        });
    }, []);

    return (
        <div className="register-page">
            <ToastContainer />
            <Row>
                <Col md={6} className="d-grid align-items-center">
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
                        today! Unlock a world of premium content, personalized
                        news feeds, and exclusive features tailored to your
                        interests.
                    </p>
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
                        <FloatingLabel label="Full Name" className="my-3">
                            <Form.Control
                                type="text"
                                name="full_name"
                                placeholder=""
                                required
                                disabled={loading ? "disabled" : ""}
                                value={formValues.full_name}
                                onChange={handleChangeValues}
                            />
                        </FloatingLabel>

                        <FloatingLabel label="Email address" className="my-3">
                            <Form.Control
                                type="email"
                                name="email"
                                placeholder=""
                                required
                                disabled={loading ? "disabled" : ""}
                                value={formValues.email}
                                onChange={handleChangeValues}
                            />
                        </FloatingLabel>

                        <Form.Group>
                            <IntlTelInput
                                id="inputPhone"
                                autoPlaceholder
                                containerClassName="intl-tel-input w-100"
                                inputClassName="form-control"
                                fieldName="phone"
                                type="tel"
                                required
                                disabled={loading ? "disabled" : ""}
                                defaultCountry={"de"}
                                value={formValues.phone}
                                onPhoneNumberChange={handleChangePhone}
                            />
                        </Form.Group>

                        <FloatingLabel label="Password" className="my-3">
                            <Form.Control
                                type="password"
                                name="password"
                                placeholder=""
                                required
                                disabled={loading ? "disabled" : ""}
                                value={formValues.password}
                                onChange={handleChangeValues}
                            />
                        </FloatingLabel>

                        <FloatingLabel
                            label="Password Confirmation"
                            className="my-3"
                        >
                            <Form.Control
                                type="password"
                                name="password_confirmation"
                                placeholder=""
                                required
                                disabled={loading ? "disabled" : ""}
                                value={formValues.password_confirmation}
                                onChange={handleChangeValues}
                            />
                        </FloatingLabel>

                        <Form.Group className="mt-2">
                            <Form.Label>Interests (optional)</Form.Label>
                            <CustomSelector
                                options={categories}
                                placeholder="Categories"
                                onChange={handleChangeInterests}
                                defaultSelectedValues={formValues.categories}
                                isMulti
                            />
                            <small>
                                <LuInfo /> You can modify categories, authors,
                                and sources at any time through settings to suit
                                your preferences.
                            </small>
                        </Form.Group>

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
                                    "Create an account"
                                )}
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
