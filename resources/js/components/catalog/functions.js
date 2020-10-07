import { PlusSolid, TrashSolid } from "@graywolfai/react-heroicons";
import React, { useEffect, useState } from "react";
import { UncontrolledCollapse } from "reactstrap";

//  global fetch
export function fetchingData(url, method, body) {
    let token = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    return fetch(url, {
        method,
        body: JSON.stringify(body),
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": token
        }
    }).then(res => {
        if (res.ok) {
            return res.json();
        } else {
            return Promise.reject(res.json().then(data => console.log(data)));
        }
    });
}

// Аккордион и дисплей всех детей
export function ReturnCatalogItem({
    item,
    i,
    handleCatalogItem,
    handleAdd,
    handleDelete
}) {
    const [open, setOpen] = useState(false);
    const icons = (
        <div className="icons">
            {item.type !== "series" && (
                <button onClick={() => handleAdd(item.id)}>
                    <PlusSolid
                        className={
                            item.parent_id === null
                                ? "icon-plus-parent"
                                : "icon-plus-subparent"
                        }
                    />
                </button>
            )}
            <button onClick={() => handleDelete(item)}>
                <TrashSolid
                    className={
                        item.parent_id === null
                            ? "icon-trash-parent"
                            : "icon-trash-subparent"
                    }
                />
            </button>
        </div>
    );
    const accButton = (
        <div className={"chevron-icon " + (open ? "open" : "")}>
            <i
                className={
                    "fa fa-chevron-right " +
                    (item.parent_id === null ? "parent" : "child")
                }
                aria-hidden="true"
            ></i>
        </div>
    );

    let menuItem;

    const handleAccordion = e => {
        handleCatalogItem(item);

        //accordion button
        if (item.children) {
            setOpen(!open);
        }
    };

    if (item.children === undefined) {
        menuItem = (
            <ul
                className={
                    item.parent_id === null
                        ? `catalog-headParent-ul`
                        : item.type === "series"
                        ? "catalog-child-ul"
                        : "catalog-headParent-ul"
                }
                key={i}
            >
                <li
                    className={
                        item.parent_id === null
                            ? "catalog-headParent "
                            : item.type === "series"
                            ? "catalog-child "
                            : "catalog-subParent "
                    }
                >
                    <div className="toggler" onClick={handleAccordion}>
                        <a href="#"> {item.name}</a>
                    </div>
                    {icons}
                    {/* {item.type !== "series" && accButton} */}
                </li>
            </ul>
        );
    } else {
        let menuItemChildren = item.children.map((item, i) => {
            let menuItem = (
                <ReturnCatalogItem
                    key={i}
                    item={item}
                    i={i}
                    handleCatalogItem={handleCatalogItem}
                    handleAdd={handleAdd}
                    handleDelete={handleDelete}
                />
            );

            return menuItem;
        });
        menuItem = (
            <ul className="d-block catalog-headParent-ul" key={i}>
                <li
                    className={
                        item.parent_id === null
                            ? "catalog-headParent"
                            : "catalog-subParent"
                    }
                >
                    <div
                        className="toggler"
                        id={`toggle-catalog-item-${item.id}`}
                        onClick={handleAccordion}
                    >
                        <a href="#">{item.name}</a>
                    </div>
                    {icons}
                    {/* {accButton} */}
                </li>
                <UncontrolledCollapse
                    className="children"
                    toggler={`#toggle-catalog-item-${item.id}`}
                >
                    {menuItemChildren}
                </UncontrolledCollapse>
            </ul>
        );
    }
    return menuItem;
}

export function findParentsInCatalog(catalog, setCatalogParents) {
    if (catalog) {
        for (const item of catalog) {
            // Find the parent object
            const parent = catalog.find(({ id }) => id === item.parent_id);
            // If the parent is found add the object to its children array
            if (parent) {
                parent.children = parent.children
                    ? [...parent.children, item]
                    : [item];
            }
        }
        const list = catalog.filter(({ parent_id }) => !parent_id);
        setCatalogParents(list);
    }
}

export function deleteFromCatalog(
    id,
    type,
    name,
    setCatalog,
    catalog,
    setNotification,
    setLoading
) {
    const url =
        type === "cat"
            ? "/admin/catalog-delete-cat"
            : "/admin/catalog-delete-series";
    console.log(url);
    fetchingData(url, "POST", {
        del_cat: id
    })
        .then(data => {
            console.log(data);
            if (data) {
                setCatalog(catalog.filter(item => item.id !== id));
                setNotification({
                    message: `${
                        type === "cat" ? "Категория" : "Серия"
                    } '${name}' успешна удаленна`,
                    error: false
                });
                setLoading(null);
            }
        })
        .catch(err => {
            console.log(err);
            setNotification({
                message: `Что-то пошло не так...`,
                error: true
            });
            setLoading(null);
        });
}
export function addToCatalog(
    id,
    type,
    name,
    setCatalog,
    catalog,
    setNotification
) {
    let url =
        type === "cat"
            ? "/admin/catalog-store-cat"
            : "/admin/catalog-store-series";
    let newItem = {
        id: catalog[catalog.length - 1].id + 1,
        name,
        parent_id: id,
        url: "#",
        sort_order: 0,
        live: 1,
        type,
        hasContent: 0,
        view_id: 1
    };
    // fetchingData(url, "POST", {
    //     name_cat: "New",
    //     cat_id: id,
    //     view_id: 1
    // })
    //     .then(res =>
    //         res.json().then(data => {
    //             if (data) {
    //                 setCatalog([...catalog, newItem]);
    //                 setNotification({
    //                     message: `Успешно добавили новую категорию`
    //                 });
    //             } else {
    //                 setNotification({
    //                     message: `Что-то пошло не так...`,
    //                     error: true
    //                 });
    //             }
    //         })
    //     )
    //     .catch(err => {
    //         console.log(err)
    //         setNotification({
    //             message: `Что-то пошло не так...`,
    //             error: true
    //         });
    //     });
}

export function filterActiveCatalogItem(name, defaultData) {
    return Object.values(defaultData).filter(item => {
        return item.name.toLowerCase().includes(name.toLowerCase());
    });
}
