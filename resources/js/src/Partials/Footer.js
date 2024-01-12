import React from "react";
import { Row, Col } from "react-bootstrap";
import {
    FaFacebook,
    FaInstagram,
    FaQuoteLeft,
    FaYoutube,
} from "react-icons/fa";
import { FaSquareXTwitter } from "react-icons/fa6";
import { Link } from "react-router-dom";

const Footer = () => {
    return (
        <footer className="mt-5 py-3 container">
            <Row>
                {/* Brand Name / Description / Social Links */}
                <Col sm={12} md={4}>
                    <h5>{process.env.REACT_APP_NAME}</h5>
                    <p>
                        <FaQuoteLeft className="mb-1 me-1" />
                        Full-stack web application built with PHP Laravel on the
                        backend and React on the frontend. It provides a
                        personalized news feeds, and engaging features.
                    </p>
                    <hr/>
                    <ul className="social-list">
                        <li>
                            <a
                                href="https://facebook.com/"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                <FaFacebook />
                            </a>
                        </li>
                        <li>
                            <a
                                href="https://twitter.com/"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                <FaSquareXTwitter />
                            </a>
                        </li>
                        <li>
                            <a
                                href="https://instagram.com/"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                <FaInstagram />
                            </a>
                        </li>
                        <li>
                            <a
                                href="https://youtube.com/"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                <FaYoutube />
                            </a>
                        </li>
                    </ul>
                </Col>


                <Col sm={12} md={4}></Col>

                {/* Top Tags */}
                <Col sm={12} md={4}>
                    <h3>Tags</h3>
                    <div className="tags">
                        <Link className="tag" to="/tags/sports">Sports</Link>
                        <Link className="tag" to="/tags/economies">Economies</Link>
                        <Link className="tag" to="/tags/health-fitness">Health & Fitness</Link>
                        <Link className="tag" to="/tags/world">World</Link>
                        <Link className="tag" to="/tags/business">Business</Link>
                        <Link className="tag" to="/tags/entertainment">Entertainment</Link>
                    </div>
                </Col>
            </Row>
            <p className="text-center text-white">
                &copy; 2024 {process.env.REACT_APP_NAME}. All rights reserved.
            </p>
        </footer>
    );
};

export default Footer;
