


var profileinfosection = document.getElementById("profile-info-section");
var myorderssection = document.getElementById("my-orders-section");
var mywishlistsection = document.getElementById("my-wishlist-section");
var myreviewsection = document.getElementById("my-review-section");
var paymentmethodsection = document.getElementById("payment-method-section");
var profile = document.getElementById("profile");
var order = document.getElementById("order");
var review = document.getElementById("review");
var wishlist = document.getElementById("wishlist");
var payment = document.getElementById("payment");


function openProfile() {
    profileinfosection.classList.remove("d-none")
    myorderssection.classList.add("d-none")
    mywishlistsection.classList.add("d-none")
    myreviewsection.classList.add("d-none")
    paymentmethodsection.classList.add("d-none")
    order.classList.remove("active")
    review.classList.remove("active")
    wishlist.classList.remove("active")
    payment.classList.remove("active")
}

function openOrder() {
    profileinfosection.classList.add("d-none")
    myorderssection.classList.remove("d-none")
    mywishlistsection.classList.add("d-none")
    myreviewsection.classList.add("d-none")
    paymentmethodsection.classList.add("d-none")
    profile.classList.remove("active")
    order.classList.add("active")
    review.classList.remove("active")
    wishlist.classList.remove("active")
    payment.classList.remove("active")
}


function openReview() {
    profileinfosection.classList.add("d-none")
    myorderssection.classList.add("d-none")
    mywishlistsection.classList.add("d-none")
    myreviewsection.classList.remove("d-none")
    paymentmethodsection.classList.add("d-none")
    profile.classList.remove("active")
    order.classList.remove("active")
    review.classList.add("active")
    wishlist.classList.remove("active")
    payment.classList.remove("active")
}


function openWishlist() {
    profileinfosection.classList.add("d-none")
    myorderssection.classList.add("d-none")
    mywishlistsection.classList.remove("d-none")
    myreviewsection.classList.add("d-none")
    paymentmethodsection.classList.add("d-none")
    profile.classList.remove("active")
    order.classList.remove("active")
    review.classList.remove("active")
    wishlist.classList.add("active")
    payment.classList.remove("active")
}


function openPayment() {
    profileinfosection.classList.add("d-none")
    myorderssection.classList.add("d-none")
    mywishlistsection.classList.add("d-none")
    myreviewsection.classList.add("d-none")
    paymentmethodsection.classList.remove("d-none")
    profile.classList.remove("active")
    order.classList.remove("active")
    review.classList.remove("active")
    wishlist.classList.remove("active")
    payment.classList.add("active")
}



var editinfopopup = document.getElementById("edit-info-popup");

var editpasspopup = document.getElementById("edit-pass-popup");

function openEdit(){
    editinfopopup.classList.remove("d-none")
}

function closeEdit(){
    editinfopopup.classList.add("d-none")
}

function openPass(){
    editpasspopup.classList.remove("d-none")
}

function closePass(){
    editpasspopup.classList.add("d-none")
}