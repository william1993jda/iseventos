import mask from "@alpinejs/mask";
import { Calendar } from "@fullcalendar/core";
import Alpine from "alpinejs";
import Toastify from "toastify-js";
import TomSelect from "tom-select";
import interactionPlugin, { Draggable } from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";
import brLocale from "@fullcalendar/core/locales/pt-br";

import "./bootstrap";
/*import "./tabulator";*/
// import "./calendar";
/*
 |--------------------------------------------------------------------------
 | 3rd Party Libraries
 |--------------------------------------------------------------------------
 |
 | Import 3rd party library JS files.
 |
 */
import "./chart";
import "./chat";
import "./copy-code";
import "./dark-mode-switcher";
import "./datepicker";
import "./dropzone";
import "./highlight";
import "./lucide";
/*
 |--------------------------------------------------------------------------
 | Custom Components
 |--------------------------------------------------------------------------
 |
 | Import JS custom components.
 |
 */
import "./maps";
import "./mobile-menu";
import "./notification";
import "./search";
import "./show-code";
import "./show-dropdown";
import "./show-modal";
import "./show-slide-over";
import "./side-menu";
import "./side-menu-tooltip";
import "./tiny-slider";
import "./tippy";
import "./tom-select";
import "./validation";
import "./zoom";
import "@left4code/tw-starter/dist/js/accordion";
import "@left4code/tw-starter/dist/js/alert";
import "@left4code/tw-starter/dist/js/dropdown";
import "@left4code/tw-starter/dist/js/modal";
import "@left4code/tw-starter/dist/js/svg-loader";
import "@left4code/tw-starter/dist/js/tab";

window.Alpine = Alpine;
window.TomSelect = TomSelect;
window.Toastify = Toastify;
window.Calendar = Calendar;
window.Draggable = Draggable;
window.interactionPlugin = interactionPlugin;
window.dayGridPlugin = dayGridPlugin;
window.timeGridPlugin = timeGridPlugin;
window.listPlugin = listPlugin;
window.brLocale = brLocale;

Alpine.plugin(mask);
Alpine.start();

function deleteConfirmation() {
    const form = document.getElementById("delete-confirmation-modal-form");

    form.setAttribute("action", this.getAttribute("data-action"));
}

const deleteConfirmationButtons = document.getElementsByClassName(
    "delete-confirmation-button"
);

Array.from(deleteConfirmationButtons).forEach(
    (el) => (el.onclick = deleteConfirmation)
);

function recoveryConfirmation() {
    const form = document.getElementById("recovery-confirmation-modal-form");
    form.setAttribute("action", this.getAttribute("data-action"));

    const input = document.getElementById("recovery-confirmation-modal-input");
    input.setAttribute("value", this.getAttribute("data-module"));
}

const recoveryConfirmationButtons = document.getElementsByClassName(
    "recovery-confirmation-button"
);

Array.from(recoveryConfirmationButtons).forEach(
    (el) => (el.onclick = recoveryConfirmation)
);
