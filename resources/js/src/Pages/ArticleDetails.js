import React, { useEffect, useState } from "react";
import { Container, Row, Col, Image, Card } from "react-bootstrap";
import { useParams } from "react-router-dom";
import AxiosConfig from "../config/AxiosConfig";
import ArticleDetailsLoader from "../Helpers/Loaders/ArticleDetailsLoader";
import ArticleNotFound from "./Articles/ArticleNotFound";

export const ArticleDetails = () => {
    const { slug } = useParams();

    const [article, setArticle] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        AxiosConfig.get(`/articles/${slug}`)
            .then((response) => {})
            .catch((error) => {
                console.error(error);
            });
    }, [slug]);

    if (loading) {
        return <ArticleDetailsLoader />;
    }

    if (!article) {
        return <ArticleNotFound />;
    }

    return (
        <Container className="mt-5">
            <Row>
                <Col md={8}>
                    <Image src={article.image} alt={article.title} fluid />
                    <h2 className="mt-4">{article.title}</h2>
                    <p>Author: {article.author}</p>
                    <p>Category: {article.category}</p>
                    <p>Source: {article.source}</p>
                    <p>Published at: {article.publishedAt}</p>
                    <Card className="mt-3">
                        <Card.Body
                            dangerouslySetInnerHTML={{
                                __html: article.content,
                            }}
                        />
                    </Card>
                </Col>
                <Col md={4}>
                    <h3 className="mb-3">Related Articles</h3>
                    <ul>
                        {article.relatedArticles.map((relatedArticle) => (
                            <li key={relatedArticle.id}>
                                <a href={`/article/${relatedArticle.slug}`}>
                                    {relatedArticle.title}
                                </a>
                            </li>
                        ))}
                    </ul>
                </Col>
            </Row>
        </Container>
    );
};
