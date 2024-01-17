import React, { useEffect, useState } from "react";
import AxiosConfig from "../../config/AxiosConfig";
import { Heading } from "./Templates/Heading";
import { Col, Row } from "react-bootstrap";
import { ExtendedArticle } from "./Templates/ExtendedArticle";
import { WideArticle } from "./Templates/WideArticle";

const TopNews = ({ showPublishInfo }) => {
    const [topNews, setTopNews] = useState([]);
    useEffect(() => {
        AxiosConfig.get("/top-news")
            .then((response) => {
                setTopNews(response.data.data.articles);
            })
            .catch((error) => {
                console.error(error);
            });
    }, []);

    return (
        <div className="top-news">
            <h3 className="border-left-primary mb-3">
                Top of what happened recently
            </h3>
            {topNews && topNews.length > 0 && (
                <Row>
                    <Col className="d-grid place-items-center" lg={3}>
                        <Row>
                            {topNews.slice(0, 3).map((article, index) => (
                                <Heading
                                    key={index}
                                    article={article}
                                    showCategory={true}
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
                            {topNews.slice(3, 4).map((article, index) => (
                                <ExtendedArticle
                                    key={index}
                                    article={article}
                                    showCategory={true}
                                    lg={12}
                                    md={12}
                                    sm={12}
                                    className="mb-2"
                                    showPublishInfo={showPublishInfo}
                                />
                            ))}
                            {topNews.slice(4, 5).map((article, index) => (
                                <WideArticle
                                    key={index}
                                    article={article}
                                    showCategory={true}
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
                            {topNews.slice(5, 8).map((article, index) => (
                                <Heading
                                    key={index}
                                    article={article}
                                    showCategory={true}
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

export default TopNews;
