import React from "react";
import { ModalHeader } from "./ModalHeader";
import styled from "styled-components";

const Container = styled.div`
    background: white;
    max-width: 500px;
    margin: 0 auto;
    box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
    border-radius: 4px;
`;
const Warning = styled.div`
    color: #0009;
    opacity: 0.9;
    margin-top: -0.8rem;
    padding: 0 1.25rem 1rem;
    line-height: 1.5;
`;

const Footer = styled.div`
    padding: 0.55rem 1rem;
    margin-bottom: -1rem;
    background-color: #424242;
`;
const ButtonsContainer = styled.div`
    display: flex;
    align-items: center;
`;
const CancelButton = styled.button`
    font-weight: 500;
    color: white;
    transition: all 0.1s ease;
    display: block;
    margin: 0 0.7rem 0 auto;
    &:hover {
        text-decoration: underline;
    }
`;
const DeleteButton = styled.button`
    padding: 0.5rem 1.5rem;
    border-radius: 5px;
    background-color: #ff4444;
    color: white;
    font-weight: 500;
    tranisiton: all 0.2s ease;
    &:hover {
        background-color: #f33737;
    }
`;

export const DeleteModal = ({
    setOpenModal,
    setNotification,
    item,
    deleteFunc,
    setItems,
    items,
    setLoading
}) => {
    const handleDelete = () => {
        deleteFunc(
            item.id,
            item.type,
            item.name,
            setItems,
            items,
            setNotification,
            setLoading
        );
        setOpenModal(false);
    };
    return (
        <Container onClick={e => e.stopPropagation()}>
            <ModalHeader message={`Удалить '${item.name}'`} />
            <Warning>
                <p>
                    Вы уверены что хотите удалить <strong>{item.name}</strong>?
                    Это действие необратимо
                </p>
            </Warning>
            <Footer>
                <ButtonsContainer>
                    <CancelButton
                        title="Выйти? "
                        onClick={() => setOpenModal(null)}
                    >
                        Отменить
                    </CancelButton>
                    <DeleteButton
                        title={`Удалить ${item.name}?`}
                        onClick={handleDelete}
                    >
                        Удалить
                    </DeleteButton>
                </ButtonsContainer>
            </Footer>
        </Container>
    );
};
