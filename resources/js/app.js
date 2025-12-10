// resources/js/app.js
import Alpine from "alpinejs";
import persist from "@alpinejs/persist";

Alpine.plugin(persist);

window.Alpine = Alpine;

// Tambahkan di bawah ini:
Alpine.data("roleHandler", () => ({
    table: null,
    formTitle: "Add Role",
    method: "post",
    formData: { id: null, name: "" },
    deleteModal: false,
    deleteId: null,

    init() {
        this.table = $("#dataTable").DataTable({
            processing: true,
            serverSide: true,
            ajax: "/roles",
            columns: [
                {
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                    orderable: false,
                    searchable: false,
                },
                { data: "name", name: "name" },
                {
                    data: "id",
                    orderable: false,
                    searchable: false,
                    className: "text-center",
                    render: (data, type, row) => `
                        <div class="flex justify-center gap-3">
                            <button type="button" data-id="${data}" data-name="${row.name}" class="edit-btn text-blue-500 hover:text-blue-700" title="Edit">
                              <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" data-id="${data}" class="delete-btn text-red-500 hover:text-red-700" title="Delete">
                              <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `,
                },
            ],
            responsive: true,
        });

        $("#dataTable").on("click", ".edit-btn", (e) => {
            const id = $(e.currentTarget).data("id");
            const name = $(e.currentTarget).data("name");
            this.editRole(id, name);
        });

        $("#dataTable").on("click", ".delete-btn", (e) => {
            const id = $(e.currentTarget).data("id");
            this.deleteId = id;
            this.deleteModal = true;
        });
    },

    editRole(id, name) {
        this.formTitle = "Edit Role";
        this.method = "put";
        this.formData.id = id;
        this.formData.name = name;
        this.$refs.form.action = `/roles/${id}`;
    },

    resetForm() {
        this.formTitle = "Add Role";
        this.method = "post";
        this.formData = { id: null, name: "" };
        this.$refs.form.action = "/roles";
    },

    confirmDelete() {
        fetch(`/roles/${this.deleteId}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document.querySelector("meta[name=csrf-token]")
                    .content,
            },
        }).then(() => {
            this.table.ajax.reload();
            this.deleteModal = false;
        });
    },
}));

Alpine.start();

// Attach search shortcuts only if elements exist on the page
document.addEventListener("DOMContentLoaded", function () {
    var searchInput = document.getElementById("search-input");
    var searchButton = document.getElementById("search-button");

    if (!searchInput || !searchButton) return;

    function focusSearchInput() {
        searchInput.focus();
    }

    searchButton.addEventListener("click", focusSearchInput);

    document.addEventListener("keydown", function (event) {
        if ((event.metaKey || event.ctrlKey) && event.key === "k") {
            event.preventDefault();
            focusSearchInput();
        }
    });

    document.addEventListener("keydown", function (event) {
        if (event.key === "/" && document.activeElement !== searchInput) {
            event.preventDefault();
            focusSearchInput();
        }
    });
});
