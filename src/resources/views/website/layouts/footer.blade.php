<footer class="container-fluid">
    <p>All Copyright &copy; Reserve by <a href="">GR Shop</a></p>
</footer>
<div class="float-cart">
    <button class="btn btn-success position-relative" id="cart-modal">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
            <path fill="none" d="M0 0h24v24H0z"></path>
            <path
                    d="M7 8V6a5 5 0 1 1 10 0v2h3a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1h3zm0 2H5v10h14V10h-2v2h-2v-2H9v2H7v-2zm2-2h6V6a3 3 0 0 0-6 0v2z">
            </path>
        </svg>
        <span
                class="position-absolute top-0 start-0 translate-middle px-2 py-1 bg-white border rounded-circle text-dark">
            0
        </span>
    </button>
</div>
<!-- float menu section -->
<div class="float-menu">
    <button class="btn btn-success position-relative" id="menu-toggler">
        <i class="fa-solid fa-bars"></i>
    </button>
</div>
<!-- cart modal -->

@include('website.layouts.footerScript')