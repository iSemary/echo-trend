import React from "react";
import { Container, Button } from "react-bootstrap";
import { Link } from "react-router-dom";
import articleNotFoundImage from "../../assets/images/not-found-article.png";

const ArticleNotFound = () => {
    return (
        <Container className="my-5 text-center">
            <img
                src={articleNotFoundImage}
                width="360px"
                alt="article not found"
            />
            <h1>Article Not Found</h1>
            <p>
                It seems like you're looking for information that is currently
                unavailable or cannot be found.
            </p>
            <Link to="/">
                <Button variant="primary">Go Home</Button>
            </Link>
        </Container>
    );
};

export default ArticleNotFound;
