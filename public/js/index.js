import { showNotes } from "./functions/showNotes.js";
import { ajaxPagination } from "./functions/ajaxPagination.js";
import { ajaxHistory } from "./functions/ajaxHistory.js";
import { confirmActions } from "./functions/confirmActions.js";

showNotes();
ajaxPagination();
ajaxHistory([showNotes, ajaxPagination]);
confirmActions();
