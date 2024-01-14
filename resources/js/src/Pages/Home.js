import React, { useEffect, useState } from "react";
import { Container } from "react-bootstrap";
import TopHeading from "./Articles/TopHeading";
import TopNews from "./Articles/TopNews";

const Home = () => {
    const [topHeading, setTopHeading] = useState([]);
    const [topNews, setTopNews] = useState([]);

    useEffect(() => {}, []);

    return (
        <Container>
            <div className="news-scroll">
                <h3>
                    Lorem ipsum is placeholder text commonly used in the
                    graphic, print, and publishing industries for previewing
                    layouts and visual mockups.
                </h3>
            </div>

            <TopHeading articles={topHeading} />

            <hr />

            
            <TopNews articles={topNews} />
        </Container>
    );
};

export default Home;
