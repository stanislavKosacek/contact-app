import { Dialog, dialogClickHandler } from "../Dialog/index.js";

export const showNotes = () => {
  const showNoteButtons = document.querySelectorAll(".show-contact-note");

  if (showNoteButtons.length > 0) {
    document.addEventListener("click", dialogClickHandler);
  }

  showNoteButtons.forEach((showNoteButton) => {
    showNoteButton.addEventListener("click", () => {
      const dialog = Dialog({
        note: showNoteButton.dataset.note,
        cancelText: showNoteButton.dataset.cancelText,
      });

      document.body.appendChild(dialog);
      dialog.showModal();
    });
  });
};
