import React from "react";
import styled from "styled-components";
import { useForm } from "react-hook-form";
import { ModalHeaderAdd } from "../ModalHeader";

const Container = styled.div`
    background: white;
    max-width: 700px;
    margin: 0 auto;
    box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
    border-radius: 4px;
`;
const BodyContainer = styled.div`
    width: 100%;
    padding: 1rem;
    margin: 0 auto;
`;
const Label = styled.label`
    margin-top: 1.25rem;
    display: block;
    width: 100%;
`;
const LabelName = styled.div`
    font-weight: 500px;
    font-size: 15px;
`;
const Input = styled.input`
    margin-top: 0.5rem;
    display: block;
`;
const CancelButton = styled.button`
    font-weight: 500;
    color: black;
    transition: all 0.1s ease;
    display: block;
    margin: 0 0.7rem 0 auto;
    &:hover {
        text-decoration: underline;
    }
`;

export const AddCatalogModal = ({ item, setOpenModal }) => {
    const { handleSubmit, register, errors } = useForm();

    const onSubmit = catalog => {
        console.log(catalog);
    };
    return (
        <Container onClick={e => e.stopPropagation()}>
            <ModalHeaderAdd message="категорию" />

            <BodyContainer>
                <form onSubmit={handleSubmit(onSubmit)}>
                    {/* name */}
                    <Label className="mt-5 block w-full" htmlFor="name">
                        <LabelName className="font-medium text-sm">
                            Name
                        </LabelName>
                        <Input
                            className="mt-2 form-input w-full"
                            type="text"
                            id="name"
                            name="name"
                            ref={register({
                                required: {
                                    value: true,
                                    message: "Это поле обязательно"
                                },
                                minLength: {
                                    value: 3,
                                    message: "Мин символов - 3"
                                },
                                maxLength: {
                                    value: 45,
                                    message: "Макс символов - 45"
                                }
                            })}
                        />
                        <span className="mt-2 text-red-600">
                            {errors?.name?.message}
                        </span>
                    </Label>

                    <button>Добавить</button>
                </form>
                <CancelButton onClick={() => setOpenModal(false)}>
                    Закрыть
                </CancelButton>
            </BodyContainer>
        </Container>
    );
};
