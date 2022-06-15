import { showNotes } from "./functions/showNotes.js";
import { ajaxPagination } from "./functions/ajaxPagination.js";
import { ajaxHistory } from "./functions/ajaxHistory.js";

showNotes();
ajaxPagination();
ajaxHistory([showNotes, ajaxPagination]);
