import React from "react";
import { Card, Col } from "react-bootstrap";
import { Link } from "react-router-dom";
export const Heading = ({ article, lg, md, sm }) => {
    return (
        <Col lg={lg} md={md} className="position-relative heading-item mb-4">
            <div className="category-tag">{article?.category?.title}</div>
            <Link
                to={`/articles/${article.slug}`}
                className="text-decoration-none"
            >
                <Card className="position-relative">
                    <Card.Img variant="top" src={article.image} />
                    <Card.Body className="position-absolute bottom-0 start-0 end-0">
                        <Card.Title className="text-white py-3">
                            {article.title}
                        </Card.Title>
                        <p className="publish-details">
                            {article.published_at} <br />
                            {article.author.name}
                        </p>
                    </Card.Body>
                </Card>
            </Link>
        </Col>
    );
};
