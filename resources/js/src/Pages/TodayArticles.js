import React from "react";
import ResourcesViewer from "./PagesTemplate/ResourcesViewer";

const TodayArticles = () => {
    return (
        <ResourcesViewer
            endPoint={`/today`}
            slug={""}
            type=""
            objectName="Today's"
        />
    );
};

export default TodayArticles;
