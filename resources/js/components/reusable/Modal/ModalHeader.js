import React from "react";

import styled from "styled-components";
const Header = styled.div`
    padding: 1.25rem;
`;
const Title = styled.h3`
    font-weight: 700;
    font-size: 17px;
    text-transform: uppercase;
    line-height: 1.5;
`;

export const ModalHeader = ({ message }) => {
    return (
        <Header>
            <Title>{message}</Title>
        </Header>
    );
};
