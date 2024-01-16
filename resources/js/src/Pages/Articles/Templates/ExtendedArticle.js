import React, { useState } from "react";
import { Card, Col } from "react-bootstrap";
import { Link } from "react-router-dom";
import ImageLoader from "../../../Helpers/Loaders/ImageLoader";
export const ExtendedArticle = ({
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
                "position-relative extended-article heading-item " + className
            }
        >
            {showCategory && (
                <div className="category-tag">{article?.category?.title}</div>
            )}
            <Link
                to={`/articles/${article?.source?.slug}/${article.slug}`}
                className="text-decoration-none"
            >
                <Card className="border-0">
                    <div className="heading-image position-relative">
                        <div
                            className="text-center"
                            style={{ display: imageLoaded ? "none" : "block" }}
                        >
                            <ImageLoader height={imageHeight} />
                        </div>
                        <div
                            style={{ display: imageLoaded ? "block" : "none" }}
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
                    <Card.Body className="bg-dark-secondary px-0">
                        <Card.Title className="text-white">
                            {article.title}
                        </Card.Title>
                        <p className="mt-0 text-muted">{article.description}</p>
                        <p className="text-muted">
                            <span className="text-white">
                                {article.published_at}
                            </span>{" "}
                            |{" "}
                            {article.author.name.length > 25
                                ? article.author.name.substring(0, 25) + "..."
                                : article.author.name}
                        </p>
                    </Card.Body>
                </Card>
            </Link>
        </Col>
    );
};
