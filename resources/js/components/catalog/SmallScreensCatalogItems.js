import React from "react";
import { ReturnCatalogItem } from "./functions";

export const SmallScreensCatalogItems = ({
    smOpen,
    setSmOpen,
    refactoredCatalog,
    handleCatalogItem,
    handleAdd,
    handleDelete
}) => {
    return (
        <>
            <div className="d-flex">
                <div
                    type="button"
                    className="small-screens-catalog-button"
                    onClick={() => setSmOpen(true)}
                >
                    <i className="fa fa-sitemap" aria-hidden="true"></i>
                    <h3 className="small-screens-catalog-header">
                        Посмотреть каталог
                    </h3>
                </div>
            </div>

            <div className={smOpen ? "sidebar-open" : "d-none"}></div>
            <div
                className={
                    "small-screens-catalog-items " + (smOpen ? "active" : "")
                }
            >
                <button
                    className="btn-x"
                    type="button"
                    onClick={() => setSmOpen(false)}
                >
                    x
                </button>
                <h3>Выберите категорию</h3>
                <div style={{ maxWidth: "350px" }}>
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
        </>
    );
};
