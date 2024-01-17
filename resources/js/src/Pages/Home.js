import React, { useEffect, useState } from "react";
import { Container } from "react-bootstrap";
import TopHeading from "./Articles/TopHeading";
import TopNews from "./Articles/TopNews";
import RandomCategoryNews from "./Articles/RandomCategoryNews";
import UserPreferredArticles from "./Articles/UserPreferredArticles";

const Home = ({ user }) => {
    /**
     * Show the publisher info for small article boxes on small screens
     */
    const [showPublishInfo, setShowPublishInfo] = useState(false);
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
        <Container>
            <TopHeading showPublishInfo={showPublishInfo} />
            <hr />
            <TopNews showPublishInfo={showPublishInfo} />
            <hr />
            <RandomCategoryNews showPublishInfo={showPublishInfo} />
            <hr />
            {user && <UserPreferredArticles />}
        </Container>
    );
};

export default Home;
