import React from "react";
import { useParams } from "react-router-dom";
import ResourcesViewer from "./PagesTemplate/ResourcesViewer";

const SourceArticles = () => {
    const { slug } = useParams();
    return (
        <ResourcesViewer
            endPoint={`/sources/${slug}/articles`}
            slug={slug}
            type="Source"
            objectKeyName="source"
            objectKeyValue="title"
        />
    );
};

export default SourceArticles;
