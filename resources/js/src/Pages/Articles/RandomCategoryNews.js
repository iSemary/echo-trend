import React, { useEffect, useState } from "react";
import AxiosConfig from "../../config/AxiosConfig";
import { Heading } from "./Templates/Heading";
import { Col, Row } from "react-bootstrap";
import { ExtendedArticle } from "./Templates/ExtendedArticle";
import { WideArticle } from "./Templates/WideArticle";
import { Link } from "react-router-dom";

const RandomCategoryNews = ({ showPublishInfo }) => {
    const [articles, setArticles] = useState([]);
    const [category, setCategory] = useState({});

    useEffect(() => {
        AxiosConfig.get("/random/category/articles")
            .then((response) => {
                setArticles(response.data.data.articles);
                setCategory(response.data.data.category);
            })
            .catch((error) => {
                console.error(error);
            });
    }, []);

    return (
        <div className="top-news">
            <div className="text-center mb-3">
                <h3 className="mb-0 text-uppercase">{category?.title}</h3>
                <Link
                    to={`/categories/${category?.slug}/articles`}
                    className="text-decoration-none text-white"
                >
                    View more articles
                </Link>
            </div>
            {articles && articles.length > 0 && (
                <Row>
                    <Col className="d-grid place-items-center" lg={3}>
                        <Row>
                            {articles.slice(0, 3).map((article, index) => (
                                <Heading
                                    key={index}
                                    article={article}
                                    lg={12}
                                    md={12}
                                    sm={12}
                                    className="small-heading mb-2"
                                    showPublishInfo={showPublishInfo}
                                />
                            ))}
                        </Row>
                    </Col>
                    <Col lg={6}>
                        <Row>
                            {articles.slice(3, 4).map((article, index) => (
                                <ExtendedArticle
                                    key={index}
                                    article={article}
                                    lg={12}
                                    md={12}
                                    sm={12}
                                    className="mb-2"
                                    showPublishInfo={showPublishInfo}
                                />
                            ))}
                            {articles.slice(4, 5).map((article, index) => (
                                <WideArticle
                                    key={index}
                                    article={article}
                                    lg={12}
                                    md={12}
                                    sm={12}
                                    className="mb-2"
                                    showPublishInfo={showPublishInfo}
                                />
                            ))}
                        </Row>
                    </Col>
                    <Col className="d-grid place-items-center" lg={3}>
                        <Row>
                            {articles.slice(5, 8).map((article, index) => (
                                <Heading
                                    key={index}
                                    article={article}
                                    lg={12}
                                    md={12}
                                    sm={12}
                                    className="mb-2 small-heading"
                                    showPublishInfo={showPublishInfo}
                                />
                            ))}
                        </Row>
                    </Col>
                </Row>
            )}
        </div>
    );
};

export default RandomCategoryNews;
