import React from "react";
import styled from "styled-components";
import { motion } from "framer-motion";
import { scaleTransition } from "../constants";

const Container = styled.div`
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(0, 0, 0, 0.8);
    z-index: 500;
`;

const Box = styled(motion.div)`
    position: relative;
    width: 100%;
`;

export const ModalContainer = ({ children }) => {
    return (
        <Container>
            <Box
                key="modal"
                transition={scaleTransition.transition}
                initial={scaleTransition.initial}
                animate={scaleTransition.animate}
                exit={scaleTransition.exit}
            >
                {children}
            </Box>
        </Container>
    );
};
