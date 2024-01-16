import React, { useState } from "react";
import { Card, Col } from "react-bootstrap";
import { Link } from "react-router-dom";
import ImageLoader from "../../../Helpers/Loaders/ImageLoader";
export const Heading = ({
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
            className={"position-relative heading-item " + className}
        >
            {showCategory && (
                <div className="category-tag">{article?.category?.title}</div>
            )}
            <Link
                to={`/articles/${article?.source?.slug}/${article.slug}`}
                className="text-decoration-none"
            >
                <Card className="heading-image position-relative">
                    <div
                        className="text-center"
                        style={{ display: imageLoaded ? "none" : "block" }}
                    >
                        <ImageLoader height={imageHeight} />
                    </div>
                    <div style={{ display: imageLoaded ? "block" : "none" }}>
                        <Card.Img
                            variant="top"
                            src={article.image}
                            height={imageHeight}
                            onLoad={(e) => {
                                setImageLoaded(true);
                            }}
                        />
                    </div>
                    <Card.Body className="position-absolute bottom-0 start-0 end-0">
                        <Card.Title className="text-white py-3 h6">
                            {article.title.length > 100
                                ? article.title.substring(0, 100) + "..."
                                : article.title}
                        </Card.Title>
                        {showPublishInfo && (
                            <p className="publish-details">
                                {article.published_at} <br />
                                {article.author.name.length > 25
                                    ? article.author.name.substring(0, 25) +
                                      "..."
                                    : article.author.name}
                            </p>
                        )}
                    </Card.Body>
                </Card>
            </Link>
        </Col>
    );
};
