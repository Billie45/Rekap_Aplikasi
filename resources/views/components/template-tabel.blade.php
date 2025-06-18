<style>
    .table-wrapper {
        overflow-x: auto;
    }

    .compact-table {
        width: 100%;
        min-width: 1000px;
        border-collapse: collapse;
        font-size: 0.85rem;
        white-space: nowrap;
        background-color: #fff;
    }

    .compact-table th,
    .compact-table td {
        border: 1px solid #e0e0e0;
        padding: 6px 10px;
        font-weight: normal;
        color: #212529;
        text-align: left;
        overflow: visible;
        white-space: normal;
        word-break: break-word;
        background-color: #fff;
        position: relative;
        max-width: 300px;
    }

    .compact-table thead th {
        background-color: #f9f9f9;
        text-align: center;
        font-weight: bold;
    }

    .compact-table tbody tr:nth-child(even) {
        background-color: #fcfcfc;
    }

    .compact-table tbody tr:hover {
        background-color: #f1f1f1;
        transition: background-color 0.2s ease-in-out;
    }

    .compact-table a {
        color: #0d6efd;
        text-decoration: none;
    }

    .compact-table a:hover {
        text-decoration: underline;
    }

    .sticky-col {
        position: sticky;
        background-color: #fff;
        z-index: 1;
    }

    .sticky-col-1 { left: 0; z-index: 2; }
    .sticky-col-2 { left: 36px; z-index: 2; }
    .sticky-col-3 { left: 300px; z-index: 2; }
    .sticky-col-4 { left: 450px; z-index: 2; }

    .mat-paginator {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        gap: 4px;
    }

    .table-wrapper {
        overflow-x: hidden;
        cursor: grab;
    }

    .table-wrapper:active {
        cursor: grabbing;
    }

    /* Default - tampilkan text */
    .btn-text {
        display: inline;
    }

    .btn-icon-only {
        display: none;
    }

    /* Media query untuk layar kecil */
    @media (max-width: 1570px) {
        .btn-text {
            display: none;
        }

        .btn-icon-only {
            display: inline;
        }

        /* Adjust button spacing untuk mobile */
        .action-buttons .btn {
            margin: 2px;
            padding: 0.25rem 0.5rem;
        }
    }

    /* Media query untuk layar sangat kecil */
    @media (max-width: 1570px) {
        .action-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 2px;
        }

        .action-buttons .btn {
            flex: 1;
            min-width: 35px;
            padding: 0.25rem;
            font-size: 0.875rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const el = document.querySelector('.table-wrapper');
        let isDown = false;
        let startX;
        let scrollLeft;

        el.addEventListener('mousedown', (e) => {
            isDown = true;
            el.classList.add('active');
            startX = e.pageX - el.offsetLeft;
            scrollLeft = el.scrollLeft;
        });
        el.addEventListener('mouseleave', () => {
            isDown = false;
            el.classList.remove('active');
        });
        el.addEventListener('mouseup', () => {
            isDown = false;
            el.classList.remove('active');
        });
        el.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - el.offsetLeft;
            const walk = (x - startX) * 1;
            el.scrollLeft = scrollLeft - walk;
        });
    });
</script>
