import React, { useEffect, useState } from "react";
import ReactDOM from "react-dom";
import "./Catalog.css";
import { CatalogItems } from "./CatalogItems";
import { ActiveCatalogItem } from "./ActiveCatalogItem";
import {
    fetchingData,
    deleteFromCatalog,
    findParentsInCatalog,
    addToCatalog
} from "./functions";
import { CatalogHeader } from "./CatalogHeader";
import { SmallScreensCatalogItems } from "./SmallScreensCatalogItems";
import { DeleteCatalogModal } from "../reusable/Modal/Catalog/DeleteCatalogModal";
import { AddCatalogModal } from "../reusable/Modal/Catalog/AddCatalogModal";
import { AnimatePresence } from "framer-motion";
import { ModalContainer } from "../reusable/Modal/ModalContainer";
import { Notifications } from "../reusable/Notifications";
import { LoadingGifSVG } from "../../LoadingGifSVG";

function Catalog() {
    const [catalog, setCatalog] = useState(null);
    const [refactoredCatalog, setRefactoredCatalog] = useState(null);
    const [title, setTitle] = useState("");
    const [activeCatalogItem, setActiveCatalogItem] = useState(null);
    const [amount, setAmount] = useState(null);
    const [smOpen, setSmOpen] = useState(false);
    const [openModal, setOpenModal] = useState(null);
    const [currentItem, setCurrentItem] = useState(null);
    const [loading, setLoading] = useState(null);
    const [notification, setNotification] = useState({
        message: "",
        error: ""
    });

    // Фетчим дату
    useEffect(() => {
        let data = document.getElementById("catalog").getAttribute("data");
        setCatalog(JSON.parse(data));
    }, []);

    useEffect(() => {
        let arrCopy;
        if (catalog) {
            arrCopy = catalog.map(item => {
                return { ...item };
            });
        }
        findParentsInCatalog(arrCopy, setRefactoredCatalog);
    }, [catalog]);

    // Обновить кол-во продуктов в activeCatalogItem
    useEffect(() => {
        if (activeCatalogItem) {
            setAmount(
                activeCatalogItem !== "loading" &&
                    Object.values(activeCatalogItem).length !== 0 &&
                    Object.values(activeCatalogItem).length
            );
        }
    }, [activeCatalogItem]);

    // Убрать оповещение
    useEffect(() => {
        if (notification.message) {
            setTimeout(() => {
                setNotification(false);
            }, 5000);
        }
    }, [notification]);

    const handleCatalogItem = item => {
        // если я хочу чтобы главные паренты ресетелли то activeCatalogItem

        // if (item.parent_id === null) {
        //     setTitle("");
        //     setActiveCatalogItem(null);
        // }

        // Только если type === series, другими словами он имеет контент который надо фетчнуть.
        if (item.type === "series") {
            setActiveCatalogItem("loading");
            setTitle(item.name);
            setSmOpen(false); // sidebar on small screens
            fetchingData(`/admin/${item.id}/catalog-select-product`, "POST", {
                select_id: item.id,
                view_id: 1
            })
                .then(data => {
                    setActiveCatalogItem(data);
                })

                .catch(err => console.log(err));
        }
    };
    const handleAddModal = id => {
        setOpenModal("add");
        // let newItem = {
        //     id: catalog[catalog.length - 1].id + 1,
        //     name: "New2",
        //     parent_id: id,
        //     url: "#",
        //     sort_order: 0,
        //     live: 1,
        //     type: "series",
        //     hasContent: 0,
        //     view_id: 1
        // };
        // setLoading("Добавляется новая категория...");
        // fetchingData("/admin/catalog-store-series", "POST", {
        //     name_cat: "New3",
        //     cat_id: id,
        //     view_id: 1
        // })
        //     .then(data => {
        //         console.log(data);
        //         if (data) {
        //             setCatalog([...catalog, newItem]);
        //             setNotification({
        //                 message: `Успешно добавили новую категорию`
        //             });
        //             setLoading(null);
        //         }
        //     })
        //     .catch(err => {
        //         console.log(err);
        //         setLoading(null);
        //         setNotification({
        //             message: `Что-то пошло не так...`,
        //             error: true
        //         });
        //     });
    };

    const handleDeleteModal = item => {
        setCurrentItem(item);
        setOpenModal("delete");
    };

    return (
        <>
            <div className="head-container mb-4">
                <CatalogHeader
                    title={activeCatalogItem !== "loading" && title}
                    amount={amount}
                />
                <div className="d-block d-lg-flex">
                    {/* Только на больших экранах */}
                    <div className="d-none d-lg-block catalog-list-headParent">
                        <CatalogItems
                            refactoredCatalog={refactoredCatalog}
                            handleCatalogItem={handleCatalogItem}
                            handleAdd={handleAddModal}
                            handleDelete={handleDeleteModal}
                        />
                    </div>
                    {/* Только для маленьких экранах */}
                    <div className="d-lg-none">
                        <SmallScreensCatalogItems
                            smOpen={smOpen}
                            setSmOpen={setSmOpen}
                            refactoredCatalog={refactoredCatalog}
                            handleCatalogItem={handleCatalogItem}
                            handleAdd={handleAddModal}
                            handleDelete={handleDeleteModal}
                        />
                    </div>

                    <div className="d-lg-none m-4">
                        <h2 className="sm-title">
                            {activeCatalogItem !== "loading" && title}
                            {amount && (
                                <span className="items-amount">({amount})</span>
                            )}
                        </h2>
                    </div>

                    <ActiveCatalogItem
                        defaultData={activeCatalogItem}
                        setDefaultData={setActiveCatalogItem}
                    />
                </div>
            </div>

            {/* modal */}
            <AnimatePresence>
                {openModal && (
                    <ModalContainer>
                        {openModal === "delete" ? (
                            <DeleteCatalogModal
                                setOpenModal={setOpenModal}
                                item={currentItem}
                                deleteFunc={deleteFromCatalog}
                                setItems={setCatalog}
                                items={catalog}
                                setNotification={setNotification}
                                setLoading={setLoading}
                            />
                        ) : (
                            <AddCatalogModal
                                setOpenModal={setOpenModal}
                                item={currentItem}
                                addFunc={addToCatalog}
                                setItems={setCatalog}
                                items={catalog}
                                setNotification={setNotification}
                                setLoading={setLoading}
                            />
                        )}
                    </ModalContainer>
                )}
            </AnimatePresence>

            {/* notification */}
            <AnimatePresence>
                {notification.message && (
                    <Notifications
                        message={notification.message}
                        error={notification.error}
                    />
                )}
            </AnimatePresence>
            {loading && (
                <Notifications message={loading}>
                    <span
                        className="d-flex align-items-center ml-1"
                        style={{ height: "20px" }}
                    >
                        <LoadingGifSVG
                            width="48"
                            height="48"
                            color="lightgray"
                        />
                    </span>
                </Notifications>
            )}
        </>
    );
}

export default Catalog;

if (document.getElementById("catalog")) {
    ReactDOM.render(<Catalog />, document.getElementById("catalog"));
}
