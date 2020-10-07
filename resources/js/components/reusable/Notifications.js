import React from "react";
import { motion } from "framer-motion";
import { slideUpTransition } from "./constants";
import styled from "styled-components";

const Box = styled(motion.div)`
    padding: 1rem 1.25rem;
    position: fixed;
    bottom: 18px;
    right: 32px;
    background-color: rgba(0, 0, 0, 0.75);
    color: white;
    font-size: 1rem;
    font-weight: 500;
    text-align: center;
    border-radius: 8px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
        0 2px 4px -1px rgba(0, 0, 0, 0.06);
    cursor: default;
`;
const Content = styled.div`
    display: flex;
    align-items: center;
    justify-content: space-between;
`;
const ErrorDiv = styled.div`
    color: #ff8b8b;
    font-weight: 700;
`;

export const Notifications = ({ message, error = false, children }) => {
    return (
        <Box
            key="notification"
            transition={slideUpTransition.transition}
            initial={slideUpTransition.initial}
            animate={slideUpTransition.animate}
            exit={slideUpTransition.exit}
        >
            <Content>
                {error ? (
                    <ErrorDiv>{message}</ErrorDiv>
                ) : (
                    <span>{message}</span>
                )}
                {children}
            </Content>
        </Box>
    );
};
