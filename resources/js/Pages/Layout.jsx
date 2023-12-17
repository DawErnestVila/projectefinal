import React from "react";
import Usuari from "./Usuari";
import Reserva from "./Reserva";

const Layout = (props) => {
    const pathname = window.location.pathname;

    // Lógica para determinar qué componente renderizar según pathname
    let contentComponent;
    if (pathname === "/") {
        // Muestra el component Usuari si la ruta es "/"
        contentComponent = <Usuari />;
    } else if (pathname === "/demanar-hora") {
        // Muestra el component Reserva si la ruta es "/demanar-hora"
        contentComponent = <Reserva user={props.user} />;
    } else {
        contentComponent = <Usuari />;
    }

    return (
        <div
            className="flex flex-col h-screen bg-[#31304D]"
            style={{ opacity: 0.9 }}
        >
            <div
                className="absolute inset-0 z-[-1]"
                style={{
                    backgroundImage:
                        "url('https://images.unsplash.com/photo-1562322140-8baeececf3df?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')",
                    backgroundSize: "cover",
                    backgroundRepeat: "no-repeat",
                    opacity: 0.2,
                }}
            ></div>
            <header className="py-4 px-6 flex justify-end">
                <a
                    href="/login"
                    className="text-[#161A30] hover:text-[#B6BBC4] font-black transition-colors duration-500"
                >
                    Login
                </a>
            </header>
            <main className="flex-grow flex flex-col items-center justify-center mx-4 sm:mx-8 text-center">
                <h1 className="text-gray-300 text-6xl mb-36 font-black">
                    Perruqueria Cirviànum
                </h1>
                {contentComponent}
            </main>
        </div>
    );
};

export default Layout;
