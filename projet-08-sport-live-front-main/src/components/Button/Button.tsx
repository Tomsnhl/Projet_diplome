import "./button.scss";
import { ComponentPropsWithoutRef } from "react";
import { motion } from "framer-motion";

type ButtonProps = ComponentPropsWithoutRef<"button"> & {
    ariaLabel?: string;
};

const Button: React.FC<ButtonProps> = ({
    type,
    className,
    onClick,
    ariaLabel,
    children,
}) => {
    return (
        <motion.button
            type={type}
            className={className}
            aria-label={ariaLabel}
            onClick={onClick}
            whileHover={{ scale: 1.05 }}
            whileTap={{ scale: 0.95 }}
            transition={{ duration: 0.3 }}
        >
            {children}
        </motion.button>
    );
};
export default Button;
