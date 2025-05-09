<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    .accordion-form {
        width: 100%;
        padding: 20px;
        font-size: 13px; 
    }

    .accordion {
        width: 100%;
    }

    .contentBx {
        margin-bottom: 15px;
        border-radius: 6px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .label {
        padding: 15px 20px;
        background:#075985;
        color: #fff;
        font-weight: 600;
        cursor: pointer;
        position: relative;
    }

    .label::before {
        content: '+';
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 20px;
        transition: 0.3s;
    }

    .contentBx.active .label::before {
        content: '-';
    }

    .contentBx.active .content {
        height: auto;
        padding: 15px 20px 25px 20px;
    }

    .content {
        padding: 0 20px;
        height: 0;
        overflow: hidden;
        transition: height 0.3s ease;
    }

    .form-row {
        display: flex;
        align-items: center;
        margin: 10px 0;
        gap: 10px;
    }

    .form-row label {
        flex: 1;
        margin: 0;
    }

    .form-row input,
    .form-row textarea {
        flex: 2;
        padding: 6px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .content textarea {
        width: 100%;
        padding: 6px;
        border: 1px solid #ccc;
        border-radius: 4px;
        resize: vertical;
    }

    button[type="submit"] {
        padding: 10px 20px;
        background:#075985;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 13px;
    }

    button[type="submit"]:hover {
        background: #1e768e;
    }
</style>
