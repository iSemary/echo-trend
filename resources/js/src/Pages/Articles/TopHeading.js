import React from "react";
import { Row } from "react-bootstrap";
import { Heading } from "./Templates/Heading";

const TopHeading = () => {
    const articles = [
        {
            id: "1",
            slug: "1",
            title: "Lorem Ipsum",
            description:
                "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
            image: "https://placehold.co/600x400",
            published_at: "1 Jan 2024",
            author: {
                slug: "john-doe",
                name: "John Doe",
            },
            category: {
                slug: "john-doe",
                title: "John Doe",
            },
            source: {
                slug: "nyt",
                name: "New York Times",
            },
        },
        {
            id: "2",
            title: "React Tutorial",
            description:
                "Learn React from scratch with this comprehensive tutorial.",
            image: "https://placehold.co/600x400",
            published_at: "2 Jan 2024",
            author: {
                slug: "jane-smith",
                name: "Jane Smith",
            },
            category: {
                slug: "john-doe",
                title: "John Doe",
            },
            source: {
                slug: "techcrunch",
                name: "TechCrunch",
            },
        },
        {
            id: "3",
            slug: "3",
            title: "Web Development Trends",
            description:
                "Explore the latest trends in web development for 2024.",
            image: "https://placehold.co/600x400",
            published_at: "3 Jan 2024",
            author: {
                slug: "michael-jones",
                name: "Michael Jones",
            },
            category: {
                slug: "john-doe",
                title: "John Doe",
            },
            source: {
                slug: "wired",
                name: "Wired",
            },
        },
        {
            id: "4",
            slug: "4",
            title: "JavaScript Best Practices",
            description:
                "Discover the best practices for writing clean and efficient JavaScript code.",
            image: "https://placehold.co/600x400",
            published_at: "4 Jan 2024",
            author: {
                slug: "sara-williams",
                name: "Sara Williams",
            },
            category: {
                slug: "john-doe",
                title: "John Doe",
            },
            source: {
                slug: "forbes",
                name: "Forbes",
            },
        },
    ];

    return (
        <div className="top-heading">
            <Row>
                {/* Big Article */}
                {articles.length > 0 && (
                    <Heading article={articles[0]} lg={6} md={12} />
                )}

                {/* Smaller Articles */}
                {articles.slice(1, 4).map((article) => (
                    <Heading article={article} lg={4} md={6} />
                ))}
            </Row>
        </div>
    );
};

export default TopHeading;
