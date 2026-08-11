import "./bootstrap";

import "bootstrap";

import * as coreui from "@coreui/coreui";

window.coreui = coreui;

document.addEventListener("DOMContentLoaded", () => {
    const sidebarToggle = document.getElementById("sidebarToggle");
    const sidebar = document.getElementById("sidebar");

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener("click", () => {
            sidebar.classList.toggle("sidebar-collapsed");
        });
    }
});
