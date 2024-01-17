import React from "react";
import { useParams } from "react-router-dom";
import ResourcesViewer from "./PagesTemplate/ResourcesViewer";

const SourceArticles = () => {
    const { slug } = useParams();
    return (
        <>
            <meta
                name="description"
                content={`Explore the latest articles from ${slug}. Stay updated with top news stories, features, and analysis from around the world.`}
            />
            <meta
                name="keywords"
                content={`${slug}, articles, breaking news, world news, features, analysis`}
            />

            <ResourcesViewer
                endPoint={`/sources/${slug}/articles`}
                slug={slug}
                type="Source"
                objectKeyName="source"
                objectKeyValue="title"
            />
        </>
    );
};

export default SourceArticles;
