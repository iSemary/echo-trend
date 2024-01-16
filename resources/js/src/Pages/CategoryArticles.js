import React from "react";
import { useParams } from "react-router-dom";
import ResourcesViewer from "./PagesTemplate/ResourcesViewer";

const CategoryArticles = () => {
    const { slug } = useParams();
    return (
        <ResourcesViewer
            endPoint={`/categories/${slug}/articles`}
            slug={slug}
            type="Category"
            objectKeyName="category"
            objectKeyValue="title"
        />
    );
};

export default CategoryArticles;
