export const confirmActions = () => {
  const confirmActions = document.querySelectorAll(".confirm-action");
  confirmActions.forEach((confirmAction) => {
    confirmAction.addEventListener("click", (e) => {
      if (!confirm(confirmAction.dataset.message)) {
        e.preventDefault();
      }
    });
  });
};
