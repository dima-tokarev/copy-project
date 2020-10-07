export const scaleTransition = {
    transition: { duration: 0.1, ease: "easeInOut" },
    initial: { opacity: 0, scale: 0.1 },
    animate: { opacity: 1, scale: 1 },
    exit: { opacity: 0, scale: 0.1 }
};
export const slideUpTransition = {
    transition: { duration: 0.2, ease: "easeOut" },
    initial: { y: "100%" },
    animate: { y: 0 },
    exit: { y: "100%" }
};
