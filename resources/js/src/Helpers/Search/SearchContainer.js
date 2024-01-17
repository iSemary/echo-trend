import React, { useState } from "react";
import { Button, Col, Form, Row } from "react-bootstrap";
import CustomSelector from "../Utilities/CustomSelector";
import { useNavigate } from "react-router-dom";

export const SearchContainer = ({ show, categories, sources }) => {
    const queryParameters = new URLSearchParams(window.location.search);
    const initialKeyword = queryParameters.get("keyword");
    const initialCategory = queryParameters.get("category");
    const initialSource = queryParameters.get("source");
    const initialDate = queryParameters.get("date");

    const currentDay = new Date().toLocaleDateString("en-CA");

    const [keyword, setKeyword] = useState(initialKeyword || "");
    const [category, setCategory] = useState(initialCategory || "");
    const [source, setSource] = useState(initialSource || "");
    const [date, setDate] = useState(initialDate || currentDay);

    const navigate = useNavigate();

    const handleChangeKeyword = (e) => {
        setKeyword(e.target.value);
    };

    const handleChangeCategory = (e) => {
        setCategory(e.id);
    };

    const handleChangeSource = (e) => {
        setSource(e.id);
    };

    const handleChangeDate = (e) => {
        setDate(e.target.value);
    };
    // Function to handle the submission of a search form.
    // Prevents the default form submission, constructs query parameters based on input values,
    // and navigates to the search results page with the constructed query parameters.
    const handleSearchSubmit = (e) => {
        e.preventDefault();
        const queryParams = `?keyword=${keyword}&category=${category}&source=${source}&date=${date}`;
        navigate(`/search${queryParams}`, { replace: true });
    };

    return (
        <Form
            className={`search-container ${show ? "visible" : "hidden"}`}
            method="GET"
            onSubmit={handleSearchSubmit}
        >
            <Row className="m-auto">
                <Col lg={4} className="mx-0 pe-0">
                    <input
                        type="search"
                        className="form-control"
                        name="keyword"
                        value={keyword}
                        required
                        onChange={handleChangeKeyword}
                        placeholder="Search for stories that unfold like secrets in the ink of headlines..."
                    />
                </Col>
                {/* Select Categories */}
                <Col lg={2} className="mx-0 pe-0 selector">
                    <CustomSelector
                        options={categories}
                        placeholder="Category"
                        onChange={handleChangeCategory}
                        defaultSelectedValues={String(category)}
                    />
                </Col>
                {/* Select Sources */}
                <Col lg={2} className="mx-0 pe-0 selector">
                    <CustomSelector
                        options={sources}
                        placeholder="Source"
                        onChange={handleChangeSource}
                        defaultSelectedValues={String(source)}
                    />
                </Col>
                <Col lg={2} className="mx-0 pe-0">
                    <input
                        type="date"
                        onChange={handleChangeDate}
                        value={date}
                        className="form-control"
                    />
                </Col>
                <Col lg={1} className="mx-0 pe-0">
                    <Button type="submit">Search</Button>
                </Col>
            </Row>
        </Form>
    );
};
