import React, { useEffect, useState } from "react";
import { Container } from "react-bootstrap";
import TopHeading from "./Articles/TopHeading";
import TopNews from "./Articles/TopNews";

const Home = () => {
    return (
        <Container>
            <TopHeading />
            <hr />
            <TopNews />
        </Container>
    );
};

export default Home;
