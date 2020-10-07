import React from "react";
import styled from "styled-components";
import { ModalHeader } from "./ModalHeader";

const Container = styled.div`
    background: white;
    max-width: 500px;
    margin: 0 auto;
    box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
    border-radius: 4px;
`;

export const AddItemModal = ({item}) => {

    return <Container>
        <ModalHeader message='Добавить категорию'/>
    </Container>;
};
