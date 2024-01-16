import React, { useEffect, useState } from "react";
import { Col, Row } from "react-bootstrap";
import { Heading } from "./Heading";
import { CgSpinnerTwoAlt } from "react-icons/cg";
import { RiDoubleQuotesL, RiDoubleQuotesR } from "react-icons/ri";
import { FaSortDown, FaSortUp } from "react-icons/fa";
import CustomSelector from "../../../Helpers/Utilities/CustomSelector";
import AxiosConfig from "../../../config/AxiosConfig";

export default function SearchResults({
    articles,
    keyword,
    currentPage,
    lastPage,
    setPage,
    loadingMore,
    dateOrder,
    setDateOrder,
    category,
    setCategory,
    source,
    setSource,
    resetArticles,
}) {
    const [categories, setCategories] = useState([]);
    const [sources, setSources] = useState([]);

    const handleNextPage = () => {
        setPage(currentPage + 1);
    };

    const handleChangeDateOrder = (e) => {
        setDateOrder(dateOrder === "DESC" ? "ASC" : "DESC");
        resetArticles();
    };

    const handleChangeCategory = (e) => {
        setCategory(e.id);
        resetArticles();
    };

    const handleChangeSource = (e) => {
        setSource(e.id);
        resetArticles();
    };

    useEffect(() => {
        AxiosConfig.get("/categories")
            .then((response) => {
                setCategories(response.data.data.categories);
            })
            .catch((error) => console.error(error));
        AxiosConfig.get("/sources")
            .then((response) => {
                setSources(response.data.data.sources);
            })
            .catch((error) => console.error(error));
    }, []);

    return (
        <div className="top-articles w-100">
            <Row className="w-100">
                <Col sm={12} md={12} lg={6}>
                    <h3 className="mb-2">
                        Search Results:&nbsp;
                        <span>
                            <RiDoubleQuotesL
                                size={18}
                                className="mb-3 text-primary"
                            />
                            {keyword}
                            <RiDoubleQuotesR
                                size={18}
                                className="mt-2 text-primary"
                            />
                        </span>
                    </h3>
                </Col>
                <Col sm={12} md={12} lg={6}>
                    <Row className="articles filter justify-content-end">
                        {/* Select Categories */}
                        <Col lg={4} className="mx-0 pe-0">
                            <CustomSelector
                                options={categories}
                                placeholder="Category"
                                onChange={handleChangeCategory}
                                defaultSelectedValues={String(category)}
                            />
                        </Col>
                        {/* Select Sources */}
                        <Col lg={4} className="mx-0 pe-0">
                            <CustomSelector
                                options={sources}
                                placeholder="Source"
                                onChange={handleChangeSource}
                                defaultSelectedValues={String(source)}
                            />
                        </Col>

                        <Col lg={2} className="mx-0 pe-0">
                            <button
                                className="btn btn-outline-primary"
                                onClick={handleChangeDateOrder}
                            >
                                Date{" "}
                                {dateOrder === "DESC" ? (
                                    <FaSortDown className="mb-1" />
                                ) : (
                                    <FaSortUp className="mt-1" />
                                )}
                            </button>
                        </Col>
                    </Row>
                </Col>
            </Row>
            <Row className="mt-3">
                {articles.map((articles, index) => (
                    <Heading
                        key={index}
                        showCategory={false}
                        article={articles}
                        sm={12}
                        md={6}
                        lg={4}
                        imageHeight={210}
                        className="mb-4"
                    />
                ))}
            </Row>
            {lastPage > currentPage && (
                <div className="w-100 text-center">
                    <button
                        disabled={loadingMore}
                        className="btn btn-primary"
                        type="button"
                        onClick={handleNextPage}
                    >
                        {loadingMore && (
                            <CgSpinnerTwoAlt className="spin-icon" />
                        )}{" "}
                        Load More
                    </button>
                </div>
            )}
        </div>
    );
}
