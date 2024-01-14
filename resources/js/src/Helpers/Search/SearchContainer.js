import React, { useState } from "react";
import { Button, Col, Form, Row } from "react-bootstrap";
import CustomSelector from "../Utilities/CustomSelector";

export const SearchContainer = ({ show, categories, sources }) => {
    const [keyword, setKeyword] = useState("");
    const [category, setCategory] = useState("");
    const [source, setSource] = useState("");
    const [date, setDate] = useState("");

    const handleChangeKeyword = (e) => {
        setKeyword(e.target.value);
    };

    const handleChangeCategory = (e) => {
        console.log(e);
        setCategory();
    };

    const handleChangeSource = (e) => {
        setSource();
    };

    const handleChangeDate = (e) => {
        setDate(e.target.value);
    };
    return (
        <Form className={`search-container ${show ? "visible" : "hidden"}`}>
            <Row className="m-auto">
                <Col lg={4} className="mx-0 pe-0">
                    <input
                        type="search"
                        className="form-control"
                        name="keyword"
                        value={keyword}
                        onChange={handleChangeKeyword}
                        placeholder="Search for stories that unfold like secrets in the ink of headlines..."
                    />
                </Col>
                {/* Select Categories */}
                <Col lg={2} className="mx-0 pe-0">
                    <CustomSelector
                        options={categories}
                        placeholder="Category"
                        onChange={handleChangeCategory}
                    />
                </Col>
                {/* Select Sources */}
                <Col lg={2} className="mx-0 pe-0">
                    <CustomSelector
                        options={sources}
                        placeholder="Source"
                        onChange={handleChangeSource}
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
                <Col lg={2} className="mx-0 pe-0">
                    <Button>Search</Button>
                </Col>
            </Row>
        </Form>
    );
};
