import React from "react";
import { useParams } from "react-router-dom";
import ResourcesViewer from "./PagesTemplate/ResourcesViewer";
import { Helmet } from "react-helmet";

const AuthorArticles = () => {
    const { sourceSlug, slug } = useParams();
    return (
        <>
            <Helmet>
                <meta
                    name="description"
                    content={`Explore articles by ${slug} from ${sourceSlug}. Stay updated with top news stories, features, and analysis.`}
                />
                <meta
                    name="keywords"
                    content={`${slug}, ${sourceSlug}, articles, breaking news, world news, features, analysis`}
                />
            </Helmet>
            <ResourcesViewer
                endPoint={`/authors/${sourceSlug}/${slug}/articles`}
                slug={slug}
                type="Author"
                objectKeyName="author"
                objectKeyValue="name"
            />
        </>
    );
};

export default AuthorArticles;
