import React from "react";
import { Button, Col, Row } from "react-bootstrap";
import { Heading } from "./Heading";

export default function TopItemArticles({
    articles,
    itemType,
    itemName,
    totalItems,
    currentPage,
    perPage,
}) {
    return (
        <div className="top-articles">
            <Row>
                <Col sm={12} md={12} lg={6}>
                    <h3 className="mb-2">
                        Top {itemName} {itemType} Articles
                        <small className="f-12">
                            &nbsp;&nbsp;Showing{" "}
                            <span className="text-primary">
                                {perPage * currentPage}&nbsp;
                            </span>
                            of
                            <span className="text-primary">
                                &nbsp;{totalItems}
                            </span>
                            &nbsp;Articles
                        </small>
                    </h3>
                </Col>
                <Col sm={12} md={12} lg={6} className="text-right">
                    <button className="btn btn-outline-primary">Date ()</button>
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
                    />
                ))}
            </Row>
        </div>
    );
}
