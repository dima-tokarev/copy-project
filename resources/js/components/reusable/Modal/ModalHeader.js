import React from "react";

import styled from "styled-components";
const DeleteHeader = styled.div`
    padding: 1.25rem;
`;
const DeleteTitle = styled.h3`
    font-weight: 700;
    font-size: 17px;
    text-transform: uppercase;
    line-height: 1.5;
`;
const AddHeader = styled.div`
    padding: 1.5rem 1.25rem;
    border-bottom: 1px solid lightgray;
`;
const AddTitle = styled.h3`
    line-height: 1.5;
    font-size: 17px;
`;

export const ModalHeaderDelete = ({ message }) => {
    return (
        <DeleteHeader>
            <DeleteTitle>{message}</DeleteTitle>
        </DeleteHeader>
    );
};

export const ModalHeaderAdd = ({ message }) => {
    return (
        <AddHeader>
            <AddTitle>Добавить {message}</AddTitle>
        </AddHeader>
    );
};
