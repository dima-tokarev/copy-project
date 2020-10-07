import React from "react";
import { ReturnCatalogItem } from "./functions";

export const CatalogItems = ({
    refactoredCatalog,
    handleCatalogItem,
    handleAdd,
    handleDelete
}) => {
    return (
        <div className="catalog-list-parent">
            <div className="catalog-list">
                {refactoredCatalog &&
                    refactoredCatalog.map((item, i) => {
                        return (
                            <ReturnCatalogItem
                                key={i}
                                item={item}
                                i={i}
                                handleCatalogItem={handleCatalogItem}
                                handleAdd={handleAdd}
                                handleDelete={handleDelete}
                            />
                        );
                    })}
            </div>
        </div>
    );
};
