import React, { useEffect, useState } from "react";
import { Container, Row, Col, Image, Card } from "react-bootstrap";
import { Link, useParams } from "react-router-dom";
import AxiosConfig from "../config/AxiosConfig";
import ArticleDetailsLoader from "../Helpers/Loaders/ArticleDetailsLoader";
import ArticleNotFound from "./Articles/ArticleNotFound";
import { Heading } from "./Articles/Templates/Heading";

export const ArticleDetails = () => {
    const { sourceSlug, slug } = useParams();

    const [article, setArticle] = useState(null);
    const [relatedArticles, setRelatedArticles] = useState([]);

    const [loading, setLoading] = useState(true);

    useEffect(() => {
        AxiosConfig.get(`/articles/${sourceSlug}/${slug}`)
            .then((response) => {
                setArticle(response.data.data.article);
                setRelatedArticles(response.data.data.related_articles);
                setLoading(false);
            })
            .catch((error) => {
                setLoading(false);
                console.error(error);
            });
    }, [sourceSlug, slug]);

    if (loading) {
        return <ArticleDetailsLoader />;
    }

    if (!article) {
        return <ArticleNotFound />;
    }

    return (
        <div className="article-page mt-5">
            <Row>
                <Col md={12}>
                    <h2>{article.title}</h2>
                    <p className="mt-2">{article.description}</p>
                    <div>
                        <Link
                            to={`/sources/${article?.source?.slug}/articles`}
                            className="highlight-link"
                        >
                            <h4>{article?.source?.title}</h4>
                        </Link>
                        <h6>{article?.source?.description}</h6>
                        {/*  */}
                        <div className="article-author">
                            <span>
                                On&nbsp;&nbsp;<i>{article.published_at}</i>
                                &nbsp;&nbsp;
                            </span>
                            <span>
                                <Link
                                    to={`/authors/${article?.author?.slug}/articles`}
                                    className="highlight-link"
                                >
                                    {article.author.name}
                                </Link>
                            </span>
                            <span> Wrote:</span>
                        </div>
                    </div>

                    <Image
                        className="mt-2"
                        src={article.image}
                        alt={article.title}
                        fluid
                    />

                    <div
                        className="mt-2"
                        dangerouslySetInnerHTML={{
                            __html: article.body,
                        }}
                    ></div>
                    <div className="mt-2">
                        <a
                            href={article.reference_url}
                            className="highlight-link"
                            target="_blank"
                            rel="noreferrer"
                        >
                            Read the full article
                        </a>
                    </div>
                    <div className="mt-2">
                        Tag:{" "}
                        <Link
                            to={`/categories/${article?.category?.slug}/articles`}
                            className="highlight-link"
                        >
                            {article?.category?.title}
                        </Link>
                    </div>
                </Col>
            </Row>

            {relatedArticles && relatedArticles.length > 0 && (
                <div className="related-articles">
                    <hr />
                    <h3 className="mb-2">Related Articles</h3>
                    <Row className="mt-3">
                        {relatedArticles.map((relatedArticle, index) => (
                            <Heading
                                key={index}
                                showCategory={false}
                                article={relatedArticle}
                                sm={12}
                                md={6}
                                lg={4}
                            />
                        ))}
                    </Row>
                </div>
            )}
        </div>
    );
};
