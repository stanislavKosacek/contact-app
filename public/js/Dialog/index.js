export const Dialog = (props) => {
  const dialogElm = document.createElement("dialog");
  const pElm = document.createElement("p");
  pElm.textContent = props.note;
  dialogElm.appendChild(pElm);

  dialogElm.innerHTML += `
        <form method="dialog">
            <button value="cancel">${props.cancelText}</button>
        </form>`;

  dialogElm.addEventListener("close", () => {
    dialogElm.remove();
  });

  return dialogElm;
};

export const dialogClickHandler = (e) => {
  if (e.target.tagName !== "DIALOG") {
    return;
  }

  const rect = e.target.getBoundingClientRect();

  const clickedInDialog =
    rect.top <= e.clientY &&
    e.clientY <= rect.top + rect.height &&
    rect.left <= e.clientX &&
    e.clientX <= rect.left + rect.width;

  if (clickedInDialog === false) {
    e.target.close();
  }
};
