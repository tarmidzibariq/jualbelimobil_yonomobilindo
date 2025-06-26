<!-- font montserat -->
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet" />

<!-- boostrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

<!-- cdn font awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

{{-- css --}}
<style>
    :root {
        --background: #fffdf6;
        --black: #171513;
        --grey: #867e77;
        --primary: #27548a;
        --yellow: #fcf259;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Montserrat", sans-serif;
        color: var(--black);
    }

    body {
        background-color: var(--background);
    }

    /* Navbar styles */
    #navbar {
        position: fixed;
        width: 100%;
        z-index: 1000;
        border-bottom: 1px solid black;
    }

    #navbar .navbar-nav .nav-link {
        font-weight: 700;
        color: var(--grey) !important;
        font-size: 16px;
        border-bottom: 2px solid transparent;
        transition: color 0.3s, border-bottom 0.3s;
    }

    #navbar .navbar-nav .nav-link.active,
    #navbar .navbar-nav .nav-link:hover {
        color: var(--primary) !important;
        border-bottom: 2px solid var(--primary);
    }

    .btn-login {
        background-color: var(--primary);
        color: var(--yellow);
        font-weight: bold;
        border: none;
        transition: background-color 0.3s ease, color 0.3s ease, transform 0.2s ease;
    }

    .btn-login:hover {
        /* Warna lebih gelap dari primary */
        background-color: #1f3f6b;
        /* Warna teks putih */
        color: #fff;
        /* Efek bayangan halus */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    #navbar .logo-text {
        font-style: italic;
        font-weight: 700;
        color: var(--primary);
    }

    #navbar .logo-text span {
        color: var(--yellow);
    }

    @media (min-width: 992px) {
        #navbar .navbar-nav .nav-item+.nav-item {
            margin-left: 30px;
        }

        #navbar .btn-login {
            margin-left: 30px;
        }
    }

    /* Custom hamburger icon for toggler */
    .navbar-toggler {
        border: none;
        background: transparent;
        padding: 4px;
        width: 40px;
        height: 32px;
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        align-items: center;
        cursor: pointer;
        box-shadow: none;
        transition: all 0.3s ease;
    }

    .navbar-toggler:focus {
        outline: none;
        box-shadow: none;
    }

    .navbar-toggler:hover {
        background-color: rgba(39, 84, 138, 0.1);
        border-radius: 4px;
    }

    .navbar-toggler span {
        display: block;
        width: 30px;
        height: 3px;
        background-color: var(--primary);
        border-radius: 2px;
        transition: all 0.3s ease-in-out;
        position: relative;
        transform-origin: center;
    }

    /* Hamburger animation - collapsed state (☰) */
    .navbar-toggler.collapsed span:nth-child(1) {
        transform: rotate(0) translate(0, 0);
    }

    .navbar-toggler.collapsed span:nth-child(2) {
        opacity: 1;
        transform: scale(1);
    }

    .navbar-toggler.collapsed span:nth-child(3) {
        transform: rotate(0) translate(0, 0);
    }

    /* Hamburger animation - expanded state (✕) */
    .navbar-toggler:not(.collapsed) span:nth-child(1) {
        transform: rotate(45deg) translate(5px, 5px);
    }

    .navbar-toggler:not(.collapsed) span:nth-child(2) {
        opacity: 0;
        transform: scale(0);
    }

    .navbar-toggler:not(.collapsed) span:nth-child(3) {
        transform: rotate(-45deg) translate(5px, -5px);
    }

    .modal .form-control {
        background-color: #eeeeee;
        border-radius: 5px;
    }


    #footer {
        background-color: #032145;
    }

    .custom-link {
        color: rgba(255, 255, 255, 0.5);
        text-decoration: none;
        transition: color 0.2s ease-in-out;
    }

    .custom-link:hover {
        color: #ffffff; /* Putih penuh saat hover */
        text-decoration: none;
    }

    /* #reqCar{
      background-color: #ffffff;
    } */

</style>
