import React, { useEffect, useState } from "react";
import { Form, Button, FloatingLabel,  Row } from "react-bootstrap";
import Select from "react-select";
import makeAnimated from "react-select/animated";
import styleVariables from "../assets/styles/variables/variables.module.scss";
import axiosConfig from "../config/AxiosConfig";
import IntlTelInput from "react-intl-tel-input-18";
import "react-intl-tel-input-18/dist/main.css";
import { ToastContainer, ToastAlert } from "../Helpers/Alerts/ToastAlert";
import { CgSpinnerTwoAlt } from "react-icons/cg";

const Profile = () => {
    const initialValues = {
        full_name: "",
        email: "",
        phone: "",
        dial_code: "",
        country_code: "",
        password: "",
        password_confirmation: "",
        interests: [],
    };
    const [formValues, setFormValues] = useState(initialValues);
    const [loading, setLoading] = useState(false);
    // Select2 animation on select
    const animatedComponents = makeAnimated();
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
        setFormValues({
            ...formValues,
            interests: e,
        });
    };

    /** create a POST request to update profile API */
    const handleUpdateProfile = (e) => {
        e.preventDefault();
        setLoading(true);

        axiosConfig
            .post("/profile", formValues)
            .then((response) => {
                setLoading(false);
                // Show success alert
                ToastAlert(response.data.message, "success");
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
    /** Getting the categories  */
    useEffect(() => {
        axiosConfig.get("/categories").then((response) => {
            setCategories(response.data.data.categories);
        });
    }, []);

    return (
        <div className="profile-page">
            <ToastContainer />
            <Form
                className="m-auto"
                method="POST"
                onSubmit={handleUpdateProfile}
            >
                <Row>
                    <FloatingLabel label="Full Name" className="col-4 my-3">
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

                    <FloatingLabel label="Email address" className="col-4 my-3">
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

                    <FloatingLabel label="Password" className="col-4 my-3">
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

                    <Form.Group className="col-4">
                        <IntlTelInput
                            id="inputPhone"
                            autoPlaceholder
                            containerClassName="intl-tel-input w-100"
                            inputClassName="form-control"
                            fieldName="phone"
                            required
                            disabled={loading ? "disabled" : ""}
                            defaultCountry={"de"}
                            value={formValues.phone}
                            onPhoneNumberChange={handleChangePhone}
                        />
                    </Form.Group>

                    <Form.Group className="col-4 mt-2">
                        <Form.Label>Interests</Form.Label>
                        <Select
                            closeMenuOnSelect={false}
                            onChange={handleChangeInterests}
                            components={animatedComponents}
                            isMulti
                            labelKey="id"
                            getOptionLabel={(option) => `${option.title}`}
                            getOptionValue={(option) => `${option.id}`}
                            options={categories}
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
                </Row>

                <Form.Group className="my-3 text-right">
                    <Button
                        variant="primary"
                        type="submit"
                        disabled={loading ? "disabled" : ""}
                    >
                        {loading ? (
                            <CgSpinnerTwoAlt className="spin-icon" />
                        ) : (
                            "Update"
                        )}
                    </Button>
                </Form.Group>
            </Form>
        </div>
    );
};

export default Profile;
