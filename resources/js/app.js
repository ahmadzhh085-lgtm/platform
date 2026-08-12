import "./bootstrap";

import "bootstrap";

import * as coreui from "@coreui/coreui";

window.coreui = coreui;

document.addEventListener("DOMContentLoaded", () => {
    const body = document.body;
    const toggleButton = document.getElementById("sidebarToggle");
    const closeButton = document.querySelector(".sidebar-close");
    const backdrop = document.getElementById("sidebarBackdrop");

    const toggleSidebar = () => {
        if (window.innerWidth >= 992) {
            body.classList.toggle("sidebar-collapsed");
            body.classList.remove("sidebar-open");
            return;
        }

        body.classList.toggle("sidebar-open");
    };

    toggleButton?.addEventListener("click", toggleSidebar);
    closeButton?.addEventListener("click", () =>
        body.classList.remove("sidebar-open"),
    );
    backdrop?.addEventListener("click", () =>
        body.classList.remove("sidebar-open"),
    );

    window.addEventListener("resize", () => {
        if (window.innerWidth >= 992) {
            body.classList.remove("sidebar-open");
        } else {
            body.classList.remove("sidebar-collapsed");
        }
    });
});
