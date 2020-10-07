import React from "react";

export const CatalogHeader = ({ title, amount }) => {
    return (
        <div className="d-none d-lg-flex">
            <div className="flex-grow-1"></div>
            <div className="flex-grow-1 offset-4">
                <h3>
                    {title ? title : "Выберите категорию"}
                    {amount && (
                        <span className="items-amount 23">
                            ({amount})
                        </span>
                    )}
                </h3>
            </div>
        </div>
    );
};
