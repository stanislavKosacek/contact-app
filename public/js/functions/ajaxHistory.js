export const ajaxHistory = (successFunctions = []) => {
  (function (history) {
    var pushState = history.pushState;
    history.pushState = function (state) {
      if (typeof history.onpushstate === "function") {
        history.onpushstate({
          state: state,
        });
      }
      return pushState.apply(history, arguments);
    };
  })(window.history);

  window.onpopstate = history.onpushstate = async (e) => {
    if (e.state && e.state.urlPath) {
      const response = await fetch(e.state.urlPath, {
        headers: {
          "content-type": "application/json",
        },
      });
      const data = await response.json();
      if (data.snippets) {
        for (let [id, htmlSnippet] of Object.entries(data.snippets)) {
          const elm = document.querySelector(`#${id}`);
          if (elm) {
            elm.innerHTML = htmlSnippet;
          }
        }
      }
      successFunctions.forEach((successFunction) => successFunction());
    } else {
      window.location.reload();
    }
  };
};
