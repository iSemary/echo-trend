import React, { useEffect, useState } from "react";
import AxiosConfig from "../../config/AxiosConfig";
import { Heading } from "./Templates/Heading";
import { Col, Row } from "react-bootstrap";
import { ExtendedArticle } from "./Templates/ExtendedArticle";
import { WideArticle } from "./Templates/WideArticle";

const TopNews = () => {
    const [topNews, setTopNews] = useState([]);
    const [showPublishInfo, setShowPublishInfo] = useState(false);

    useEffect(() => {
        AxiosConfig.get("/top-news")
            .then((response) => {
                setTopNews(response.data.data.articles);
            })
            .catch((error) => {
                console.error(error);
            });
    }, []);

    /**
     * Show the publisher info for small article boxes on small screens
     */
    useEffect(() => {
        const handleResize = () => {
            setShowPublishInfo(window.innerWidth < 992);
        };
        handleResize();
        window.addEventListener("resize", handleResize);
        return () => {
            window.removeEventListener("resize", handleResize);
        };
    }, []);
    return (
        <div className="top-news">
            <h5 className="border-left-primary mb-3">
                Top of what happened recently
            </h5>
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
