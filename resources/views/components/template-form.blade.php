<style>
    /* Container Form */
    form {
    background: #ffffff;
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Label */
    form label {
    display: block;
    margin-bottom: 0rem;
    font-weight: 600;
    color: #333;
    }

    /* Input, Select, Textarea */
    input[type="text"],
    input[type="password"],
    input[type="date"],
    input[type="number"],
    input[type="tel"],
    select {
    width: 100%;
    padding: 8px;
    margin: 5px 0 15px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
    }
    form textarea {
    width: 100%;
    padding: 0.75rem 1rem;
    margin-bottom: 0rem;
    border: 1px solid #ccc;
    border-radius: 0.75rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    background-color: #f9f9f9;
    }

    form input[type="text"]:focus,
    form input[type="date"]:focus,
    form select:focus,
    form textarea:focus {
    background-color: #075985;
    background-color: #fff;
    outline: none;
    box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.2);
    }

    /* Button */
    form button {
    background-color: #f4f4f4;
    color: rgb(0, 0, 0);
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 0.75rem;
    cursor: pointer;
    font-size: 1rem;
    transition: background-color 0.3s ease;
    }

    form button:hover {
    background-color: #075985;
    color: rgb(255, 255, 255);
    }

    /* Optional: section/card like Informasi Akun */
    .card-section {
    background-color: #f4f6f8;
    padding: 1rem;
    margin-top: 2rem;
    border-radius: 0.75rem;
    font-weight: 500;
    color: #555;
    }

    .form-group {
        margin-bottom: 1rem; /* atau sesuai kebutuhan */
    }
</style>
