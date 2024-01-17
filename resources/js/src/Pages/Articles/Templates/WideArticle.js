import React, { useState } from "react";
import { Card, Col, Row } from "react-bootstrap";
import { Link } from "react-router-dom";
import ImageLoader from "../../../Helpers/Loaders/ImageLoader";
export const WideArticle = ({
    article,
    showCategory,
    lg,
    md,
    sm,
    imageHeight,
    className,
    showPublishInfo = true,
}) => {
    const [imageLoaded, setImageLoaded] = useState(false);

    return (
        <Col
            lg={lg}
            md={md}
            sm={sm}
            className={
                "position-relative wide-article heading-item " + className
            }
        >
            {showCategory && (
                <div className="category-tag">{article?.category?.title}</div>
            )}
            <Link
                to={`/articles/${article?.source?.slug}/${article.slug}`}
                className="text-decoration-none"
            >
                <Card className="border-0 bg-dark-secondary">
                    <Row>
                        <Col lg={6} md={6}>
                            <div className="heading-image position-relative">
                                <div
                                    className="text-center"
                                    style={{
                                        display: imageLoaded ? "none" : "block",
                                    }}
                                >
                                    <ImageLoader height={imageHeight} />
                                </div>
                                <div
                                    style={{
                                        display: imageLoaded ? "block" : "none",
                                    }}
                                >
                                    <Card.Img
                                        variant="top"
                                        src={article.image}
                                        height={imageHeight}
                                        onLoad={(e) => {
                                            setImageLoaded(true);
                                        }}
                                    />
                                </div>
                            </div>
                        </Col>
                        <Col lg={6} md={6}>
                            <Card.Body className="bg-dark-secondary px-0">
                                <Card.Title className="text-white">
                                    {article.title}
                                </Card.Title>
                                <p className="text-muted">
                                    <span className="text-white">
                                        {article.published_at}
                                    </span>{" "}
                                    |{" "}
                                    {article.author.name.length > 25
                                        ? article.author.name.substring(0, 25) +
                                          "..."
                                        : article.author.name}
                                </p>
                            </Card.Body>
                        </Col>
                    </Row>
                </Card>
            </Link>
        </Col>
    );
};
