import React, { useEffect, useState } from "react";
import { Col, Row } from "react-bootstrap";
import { Heading } from "./Templates/Heading";
import AxiosConfig from "../../config/AxiosConfig";

const TopHeading = () => {
    const [topHeadings, setTopHeadings] = useState([]);
    const [showPublishInfo, setShowPublishInfo] = useState(false);

    useEffect(() => {
        AxiosConfig.get("/top-headings")
            .then((response) => {
                setTopHeadings(response.data.data.headings);
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
        <div className="overflow-hidden">
            <div className="news-scroll">
                <h3>
                    {topHeadings &&
                        topHeadings.length > 0 &&
                        topHeadings.map((article, index) => (
                            <span
                                key={index}
                                className={index % 2 ? "text-white" : ""}
                            >
                                &nbsp;&nbsp;{article.title}&nbsp;&nbsp;
                            </span>
                        ))}
                </h3>
            </div>
            <div className="top-heading">
                <Row>
                    {/* Big Article */}
                    {topHeadings && topHeadings.length > 0 && (
                        <Heading
                            article={topHeadings[0]}
                            showCategory={true}
                            lg={6}
                            md={12}
                            sm={12}
                            className="mb-2"
                        />
                    )}

                    {/* Smaller Articles */}
                    <Col lg={6} md={12} sm={12}>
                        <Row>
                            {topHeadings &&
                                topHeadings
                                    .slice(1, 5)
                                    .map((article, index) => (
                                        <Heading
                                            key={index}
                                            article={article}
                                            showCategory={true}
                                            lg={6}
                                            md={12}
                                            sm={12}
                                            className="mb-2"
                                            showPublishInfo={showPublishInfo}
                                        />
                                    ))}
                        </Row>
                    </Col>
                </Row>
            </div>
        </div>
    );
};

export default TopHeading;
