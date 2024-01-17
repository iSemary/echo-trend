import React from "react";
import { useParams } from "react-router-dom";
import ResourcesViewer from "./PagesTemplate/ResourcesViewer";

const AuthorArticles = () => {
    const { sourceSlug, slug } = useParams();
    return (
        <ResourcesViewer
            endPoint={`/authors/${sourceSlug}/${slug}/articles`}
            slug={slug}
            type="Author"
            objectKeyName="author"
            objectKeyValue="name"
        />
    );
};

export default AuthorArticles;
