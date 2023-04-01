import "./bootstrap";

import Alpine from "alpinejs";

import swal from "sweetalert2";
window.Swal = swal;
if (document.querySelector(".status-success") != null) {
    swal.fire("Products has been updated!", "", "success");
}

window.Alpine = Alpine;

Alpine.start();
