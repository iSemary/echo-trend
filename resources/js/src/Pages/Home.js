import React, { useEffect, useState } from "react";
import { Container } from "react-bootstrap";
import TopHeading from "./Articles/TopHeading";
import TopNews from "./Articles/TopNews";

const Home = () => {
    const [topNews, setTopNews] = useState([]);

    useEffect(() => {}, []);

    return (
        <Container>
            <TopHeading />
            <hr />
            <TopNews articles={topNews} />
        </Container>
    );
};

export default Home;
