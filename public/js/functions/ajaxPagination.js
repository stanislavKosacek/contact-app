export const ajaxPagination = () => {
  const paginationLinks = document.querySelectorAll(".pagination a");
  paginationLinks.forEach((paginationLink) => {
    paginationLink.addEventListener("click", (e) => {
      e.preventDefault();
      history.pushState(
        { urlPath: paginationLink.href },
        "",
        paginationLink.href
      );
    });
  });
};
