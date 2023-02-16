"use strict";
function HandleDataTable(_tbl_name) {
    $(document).ready(() => {
        $(_tbl_name).dataTable();
    });
}
HandleDataTable("#table-category");
HandleDataTable("#table-user");
HandleDataTable("#table-role");
HandleDataTable("#table-ekstra");
HandleDataTable("#table-article");
HandleDataTable("#table-kompetensi");
HandleDataTable("#table-ekstra-galeri");
HandleDataTable("#table-activity");
HandleDataTable("#table-data-backup");
HandleDataTable("#table-trash-article");


