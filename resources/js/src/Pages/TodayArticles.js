import React from "react";
import ResourcesViewer from "./PagesTemplate/ResourcesViewer";
import { Helmet } from "react-helmet";

const TodayArticles = () => {
    return (
        <>
            <Helmet>
                <meta
                    name="description"
                    content="Explore the latest news and updates for today from around the world on Your News App. Stay informed with top headlines, breaking news, and more."
                />
                <meta
                    name="keywords"
                    content="today's news, breaking news, current events, top headlines, news updates, world news, local news, Your News App"
                />
            </Helmet>
            <ResourcesViewer
                endPoint={`/today`}
                slug={""}
                type=""
                objectName="Today's"
            />
        </>
    );
};

export default TodayArticles;
