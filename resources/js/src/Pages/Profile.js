import React, { useEffect, useState } from "react";
import { Form, Button, FloatingLabel, Row, Col } from "react-bootstrap";
import AxiosConfig from "../config/AxiosConfig";
import IntlTelInput from "react-intl-tel-input-18";
import "react-intl-tel-input-18/dist/main.css";
import { ToastContainer, ToastAlert } from "../Helpers/Alerts/ToastAlert";
import CustomSelector from "../Helpers/Utilities/CustomSelector";
import { CgSpinnerTwoAlt } from "react-icons/cg";

const Profile = () => {
    const [loading, setLoading] = useState(false);
    // User Details
    const [profile, setProfile] = useState([]);
    /**
     * User Preferences
     */
    const [userCategories, setUserCategories] = useState([]);
    const [userAuthors, setUserAuthors] = useState([]);
    const [userSources, setUserSources] = useState([]);
    // Categories options
    const [categories, setCategories] = useState([]);
    // Authors options
    const [authors, setAuthors] = useState([]);
    // Sources options
    const [sources, setSources] = useState([]);
    /** Change form values states on change inputs based on name and value */
    const handleChangeValues = (e) => {
        const { name, value } = e.target;
        setProfile({
            ...profile,
            [name]: value,
        });
    };

    const handleChangePhone = (isValid, value, selectedCountryData) => {
        setProfile({
            ...profile,
            phone: value,
            dial_code: selectedCountryData.dialCode,
            country_code: selectedCountryData.iso2,
        });
    };
    const handleChangeCategories = (e) => {
        const selectedIds = e.map((option) => option.id);
        setUserCategories(selectedIds);
    };

    const handleChangeAuthors = (e) => {
        const selectedIds = e.map((option) => option.id);
        setUserAuthors(selectedIds);
    };

    const handleChangeSources = (e) => {
        const selectedIds = e.map((option) => option.id);
        setUserSources(selectedIds);
    };

    /** create a POST request to update profile API */
    const handleUpdateProfile = (e) => {
        e.preventDefault();
        setLoading(true);

        AxiosConfig.post("/profile", {
            ...profile,
            categories: userCategories,
            authors: userAuthors,
            sources: userSources,
        })
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
        // TODO use redux

        AxiosConfig.get("/categories")
            .then((response) => {
                setCategories(response.data.data.categories);
            })
            .catch((error) => console.error(error));
        AxiosConfig.get("/authors")
            .then((response) => {
                setAuthors(response.data.data.authors);
            })
            .catch((error) => console.error(error));
        AxiosConfig.get("/sources")
            .then((response) => {
                setSources(response.data.data.sources);
            })
            .catch((error) => console.error(error));

        AxiosConfig.get("/profile")
            .then((response) => {
                setProfile(response.data.data.profile.user);
                setUserCategories(
                    response.data.data.profile.interests.categories
                );
                setUserAuthors(response.data.data.profile.interests.authors);
                setUserSources(response.data.data.profile.interests.sources);
            })
            .catch((error) => console.error(error));
    }, []);

    return (
        <Row>
            <Col className="m-auto" sm={12} md={9} lg={6}>
                <Form method="POST" onSubmit={handleUpdateProfile}>
                    <ToastContainer />
                    <h5>Update Your Profile</h5>
                    <small>Control what you see, and what you care</small>
                    <FloatingLabel label="Full Name" className="my-3">
                        <Form.Control
                            type="text"
                            name="full_name"
                            placeholder=""
                            required
                            disabled={loading ? "disabled" : ""}
                            value={profile.full_name}
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
                            value={profile.email}
                            onChange={handleChangeValues}
                        />
                    </FloatingLabel>

                    <FloatingLabel label="Password" className="my-3">
                        <Form.Control
                            type="password"
                            name="password"
                            autoComplete="one-time-code"
                            placeholder=""
                            disabled={loading ? "disabled" : ""}
                            value={profile.password}
                            onChange={handleChangeValues}
                        />
                    </FloatingLabel>

                    <Form.Group>
                        {profile ? (
                            <IntlTelInput
                                id="inputPhone"
                                autoPlaceholder
                                containerClassName="intl-tel-input w-100"
                                inputClassName="form-control"
                                fieldName="phone"
                                required
                                disabled={loading ? "disabled" : ""}
                                value={String(profile.phone)}
                                onPhoneNumberChange={handleChangePhone}
                            />
                        ) : (
                            ""
                        )}
                    </Form.Group>

                    <hr />

                    <Form.Group className="mt-2">
                        <Form.Label>Interests</Form.Label>
                        <CustomSelector
                            options={categories}
                            placeholder="Categories"
                            onChange={handleChangeCategories}
                            isMulti
                            defaultSelectedValues={userCategories}
                        />
                    </Form.Group>

                    <Form.Group className="mt-2">
                        <Form.Label>Authors</Form.Label>
                        <CustomSelector
                            options={authors}
                            placeholder="Authors"
                            onChange={handleChangeAuthors}
                            labelKey="name"
                            isMulti
                            defaultSelectedValues={userAuthors}
                        />
                    </Form.Group>

                    <Form.Group className="mt-2">
                        <Form.Label>Sources</Form.Label>
                        <CustomSelector
                            options={sources}
                            placeholder="Sources"
                            onChange={handleChangeSources}
                            isMulti
                            defaultSelectedValues={userSources}
                        />
                    </Form.Group>

                    <Form.Group className="text-right my-3">
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
            </Col>
        </Row>
    );
};

export default Profile;
