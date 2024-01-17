import React from "react";
import { useParams } from "react-router-dom";
import ResourcesViewer from "./PagesTemplate/ResourcesViewer";
import { Helmet } from "react-helmet";

const CategoryArticles = () => {
    const { slug } = useParams();
    
    return (
        <>
            <Helmet>
                <meta
                    name="description"
                    content={`Explore the latest articles in the ${slug} category. Stay updated with top news stories, features, and analysis in ${slug}.`}
                />
                <meta
                    name="keywords"
                    content={`${slug}, articles, breaking news, world news, features, analysis`}
                />
            </Helmet>
            <ResourcesViewer
                endPoint={`/categories/${slug}/articles`}
                slug={slug}
                type="Category"
                objectKeyName="category"
                objectKeyValue="title"
            />
        </>
    );
};

export default CategoryArticles;
