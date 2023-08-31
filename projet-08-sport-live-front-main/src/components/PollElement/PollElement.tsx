import "./pollelement.scss";
import { motion } from "framer-motion";

const PollElement: React.FC = () => {
    return (
        <>
            {/* A MAPPER */}
            <motion.li transition={{ duration: 0.2 }}>
                <motion.button
                    transition={{ delay: 0.2 }}
                    initial={{ y: 20, opacity: 0 }}
                    animate={{ y: 0, opacity: 1 }}
                    whileHover={{ scale: 1.05 }}
                    whileTap={{ scale: 0.98 }}
                >
                    Choix
                </motion.button>
            </motion.li>
            <motion.li transition={{ duration: 0.2 }}>
                <motion.button
                    transition={{ delay: 0.3 }}
                    initial={{ y: 20, opacity: 0 }}
                    animate={{ y: 0, opacity: 1 }}
                    whileHover={{ scale: 1.05 }}
                    whileTap={{ scale: 0.98 }}
                >
                    Choix
                </motion.button>
            </motion.li>
            <motion.li transition={{ duration: 0.2 }}>
                <motion.button
                    transition={{ delay: 0.4 }}
                    initial={{ y: 20, opacity: 0 }}
                    animate={{ y: 0, opacity: 1 }}
                    whileHover={{ scale: 1.05 }}
                    whileTap={{ scale: 0.98 }}
                >
                    Choix
                </motion.button>
            </motion.li>
            <motion.li transition={{ duration: 0.2 }}>
                <motion.button
                    transition={{ delay: 0.5 }}
                    initial={{ y: 20, opacity: 0 }}
                    animate={{ y: 0, opacity: 1 }}
                    whileHover={{ scale: 1.05 }}
                    whileTap={{ scale: 0.98 }}
                >
                    Choix
                </motion.button>
            </motion.li>
        </>
    );
};
export default PollElement;
