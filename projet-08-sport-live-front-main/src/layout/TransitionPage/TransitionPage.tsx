import { motion, useIsPresent } from "framer-motion";

const TransitionPage: React.FC = () => {
    const isPresent = useIsPresent();

    return (
        <motion.div
            initial={{ scaleX: 2 }}
            animate={{
                scaleX: 0,
                transition: { duration: 0.8, ease: "circOut" },
            }}
            exit={{
                scaleX: 1,
                transition: { duration: 0.8, ease: "circIn" },
            }}
            style={{ originX: isPresent ? 1 : 0 }}
            className="privacy-screen"
        />
    );
};
export default TransitionPage;
