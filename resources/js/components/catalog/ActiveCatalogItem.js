import React, { useEffect, useState } from "react";
import { LoadingGifSVG } from "../../LoadingGifSVG";
import styled from "styled-components";
import {
    PlusOutline,
    SearchSolid,
    TrashSolid
} from "@graywolfai/react-heroicons";
import { filterActiveCatalogItem } from "./functions";
import { AddButtonBlueColor } from "../reusable/constants";

const HeaderContainer = styled.div`
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 1rem;
    border-bottom: 1px solid lightgray;
    background-color: white;
    @media (max-width: 576px) {
        flex-flow: column-reverse;
    }
`;
const InputContainer = styled.div`
    position: relative;
    width: 45%;
    @media (max-width: 576px) {
        width: 65%;
    }
`;
const SearchSpan = styled.span`
    position: absolute;
    top: 0;
    bottom: 0;
    left: 18px;
    display: flex;
    align-items: center;
    line-height: 1;
    padding-bottom: 2px;
`;
const SearchSpanIcon = styled.span`
    width: 1.5rem;
    height: 1.5rem;
    color: rgba(0, 0, 0, 0.5);
`;
const Input = styled.input`
    max-width: 400px;
    width: 100%;
    padding: 0.5rem 0rem;
    padding-left: 2.5rem;
    border: 1px solid darkgray;
    border-radius: 5px;
    margin-left: 0.75rem;
    font-size: 1rem;
    &:focus {
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.5);
        outline: none;
        border: 1px solid transparent;
    }
`;
const AddButton = styled.button`
    display: flex;
    align-items: center;
    padding: 0.5rem 1.5rem;
    background-color: ${props => props.color.bg};
    transition: all 0.3s ease;
    border-radius: 5px;
    color: white;
    font-size: 17px;
    &:hover {
        background-color: ${props => props.color.hover};
    }
    &:focus {
        box-shadow: ${props => props.color.focus};
    }
    @media (max-width: 576px) {
        display: flex;
        justify-content: space-between;
        border-radius: 25px;
        padding: 0.75rem 1.25rem;
        margin: 23px auto;
    }
`;
const IconSpan = styled.span`
    height: 1.75rem;
    width: 1.75rem;
    margin-left: 0.5rem;
`;
const ImgDiv = styled.div`
    padding-bottom: 66.666667%;
`;
function Header({ handleChange }) {
    return (
        <HeaderContainer>
            <InputContainer>
                <Input
                    type="text"
                    placeholder="Поиск"
                    onChange={handleChange}
                />
                <SearchSpan>
                    <SearchSpanIcon>
                        <SearchSolid />
                    </SearchSpanIcon>
                </SearchSpan>
            </InputContainer>
            <AddButton title="Добавить продукт" color={AddButtonBlueColor}>
                <span>Добавить</span>
                <IconSpan primary>
                    <PlusOutline />
                </IconSpan>
            </AddButton>
        </HeaderContainer>
    );
}

export const ActiveCatalogItem = ({ defaultData }) => {
    const [activeCatalogItem, setActiveCatalogItem] = useState(null);
    const [inputValue, setInputValue] = useState("");

    useEffect(() => {
        setActiveCatalogItem(defaultData);
        setInputValue("");
    }, [defaultData]);

    const handleChange = e => {
        setActiveCatalogItem(
            filterActiveCatalogItem(e.target.value, defaultData)
        );
    };

    if (activeCatalogItem === "loading") {
        return (
            <div className="active-catalog-item-container d-flex justify-content-center">
                <LoadingGifSVG color="#0009" />
            </div>
        );
    }
    if (defaultData && defaultData.length === 0) {
        return (
            <div className="active-catalog-item-container d-flex justify-content-center">
                <h5 className="active-catalog-empty-title">Пока ничего нет.</h5>
            </div>
        );
    }
    if (activeCatalogItem && activeCatalogItem.length === 0) {
        return (
            <div className="active-catalog-item-container">
                <Header handleChange={handleChange} />
                <div className="d-flex justify-content-center">
                    <h5 className="active-catalog-empty-title">
                        Ничего не найдено.
                    </h5>
                </div>
            </div>
        );
    }
    return (
        <div className="active-catalog-item-container">
            {defaultData && <Header handleChange={handleChange} />}
            <div className="d-flex justify-content-center">
                <div className="active-catalog-items">
                    {activeCatalogItem &&
                        Object.values(activeCatalogItem).map((item, i) => {
                            return (
                                <div key={i} className="active-catalog-item">
                                    <div className="img-container">
                                        <img
                                            className="active-catalog-item-image"
                                            src="https://images-na.ssl-images-amazon.com/images/I/81vZaXuCQ-L._SL1500_.jpg"
                                            // src="https://m.media-amazon.com/images/I/41unuBlc5IL.jpg"
                                            alt={item}
                                        />
                                        <span
                                            className="img-delete-icon"
                                            title="Удалить продукт"
                                        >
                                            <TrashSolid
                                                height="1.5rem"
                                                width="1.5rem"
                                            />
                                        </span>
                                    </div>
                                    <div className="active-catalog-item-name">
                                        {item.name}
                                    </div>
                                </div>
                            );
                        })}
                </div>
            </div>
        </div>
    );
};
