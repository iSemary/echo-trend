import React from "react";
import { Col, Row } from "react-bootstrap";
import { Heading } from "./Heading";
import { CgSpinnerTwoAlt } from "react-icons/cg";
import { RiDoubleQuotesL, RiDoubleQuotesR } from "react-icons/ri";

export default function TopItemArticles({
    articles,
    itemType,
    itemName,
    totalItems,
    currentPage,
    lastPage,
    perPage,
    setPage,
    loadingMore,
    filtering,
}) {
    const handleNextPage = () => {
        setPage(currentPage + 1);
    };

    return (
        <div className="top-articles w-100">
            {itemName && (
                <Row>
                    <Col sm={12} md={12} lg={8}>
                        <h3 className="mb-2">
                            Top&nbsp;
                            <span>
                                <RiDoubleQuotesL
                                    size={18}
                                    className="mb-3 text-primary"
                                />
                                {itemName}
                                <RiDoubleQuotesR
                                    size={18}
                                    className="mt-2 text-primary"
                                />
                            </span>
                            &nbsp;{itemType}&nbsp;Articles
                            <small className="f-12">
                                &nbsp;&nbsp;Showing
                                <span className="text-primary">
                                    &nbsp;
                                    {Math.min(
                                        currentPage * perPage,
                                        totalItems
                                    )}
                                </span>
                                &nbsp;of
                                <span className="text-primary">
                                    &nbsp;{totalItems}
                                </span>
                                &nbsp;Articles
                            </small>
                        </h3>
                    </Col>
                </Row>
            )}

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
