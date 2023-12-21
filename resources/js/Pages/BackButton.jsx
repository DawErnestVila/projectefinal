import React from "react";

const BackButton = () => {
    return (
        <a
            className="flex justify-start items-start space-x-2 text-gray-200 hover:text-gray-400 transition-colors duration-300 hover:cursor-pointer"
            href="/"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                strokeWidth="1.5"
                stroke="currentColor"
                className="w-6 h-6"
            >
                <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"
                />
            </svg>

            <span>Cancel·lar</span>
        </a>
    );
};

export default BackButton;
