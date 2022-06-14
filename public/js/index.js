import { Dialog, dialogClickHandler } from "./Dialog/index.js";

const showNoteButtons = document.querySelectorAll('.show-contact-note');
showNoteButtons.forEach(showNoteButton => {
    showNoteButton.addEventListener('click', () => {
        const dialog = Dialog({
            note: showNoteButton.dataset.note,
            cancelText: showNoteButton.dataset.cancelText,
        });
        document.body.appendChild(dialog);
        dialog.showModal();
    })
})

document.addEventListener('click', dialogClickHandler)
