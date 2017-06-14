function buildcontent(){
    var products = JSON.parse(localStorage.getItem("products"));
    var lastProduct = products.length;
    var productsHTML = "";
    products.map((item,idx) => {
        if(idx <= lastProduct) {
        var style="background-image:url('"+item.productImage+"')";
        productsHTML += '<div class="col-md-4 col-sm-6 col-xs-12 products-grid">';
        productsHTML += '<div class="product-img" style="'+style+'"></div>';
        productsHTML += '<div class="product-desp">';
        productsHTML += '<p class="product-name">' + item.productName + '</p>';
        productsHTML += '<p class="owner-name">' + item.owningOrganisationName + '</p>';
        productsHTML += '<button class="product-details btn btn-success btn-xs" data-toggle="modal" data-target="#' + item.productId + '" data-product-index="' + item.productId + '">View Detail</button>';
        productsHTML += '</div>';
        productsHTML += '</div>';
    }
});
    $("#products").html(productsHTML);
    window.addEventListener('resize',function(){
        var itemWidth = $('.product-img')[0];
        // console.log(itemWidth);
        $('.product-img').height(itemWidth.width);
    });
    $(".product-details").click(function(){
        var id = $(this).data('product-index');
        var theModal = $('.modal')[0];
        setModalData(id);
        $(theModal).attr('id',id);
    })
}
function setModalData(id){
    var products = JSON.parse(localStorage.getItem("products"));
    var i,targetProduct;
    for(i=0;i<products.length;i++){
        if(products[i].productId == id){
            targetProduct = products[i];
        }
    }
    console.log(targetProduct);
    $("#product-name-head").text("Product Name: " + targetProduct.productName);
    $("#product-id").text("Product Id: " + targetProduct.productId);
    $("#product-number").text("Product Number: " + targetProduct.productNumber);
    $("#product-status").text("Product Status: " + targetProduct.status);
    $("#product-own-org-id").text("Product Owning Organization Id: " + targetProduct.owningOrganisationId);
    $("#product-own-org-number").text("Product Owning Organization Number: " + targetProduct.owningOrganisationNumber);
    $("#product-own-org-name").text("Product Owning Organization Name: " + targetProduct.owningOrganisationName);
    $("#product-despcription").text(targetProduct.productDescription);
    $("#product-cat-id").text("Product Category: " + targetProduct.productCategoryId);
    var address = targetProduct.addresses[0];
    var addressItem = new Array();
    Object.keys(address).forEach(function (key) {
        var val = address[key];
        if(key != 'address_type' || val.length != 0)
            addressItem.push(val);
    });
    $("#product-address").text("Product Address: " + addressItem.join(' '));
    $("#product-lacation").text("Product Boundary: " + targetProduct.boundary);
    $("#product-score").text("Product Score: " + targetProduct.score);
    console.log(addressItem);
    $("#modal-body-image").attr("src",targetProduct.productImage);
}
function buildPager(){
    var total = localStorage.getItem("total");
    let pages = total % 12 != 0 ? parseInt(total / 12) + 1 : total / 12;
    var i;
    var pagesHTML = '<ul class="pagination">';
    for(i = 1; i <= pages; i++) {
        var pageButton = "<li><a href='#' class='page-controller' data-page-index="+i+">"+i+"</a><li>";
        pagesHTML += pageButton;
    }
    pagesHTML += "</ul>";
    $("#pages").html(pagesHTML);
    $(".page-controller").click(function(){
        var page = $(this).data('page-index');
        window.loadDoc(page);
    });
}
function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 7,
        center: {lat: -33.3493146, lng: 149.7347251},
    });
    var products = JSON.parse(localStorage.getItem("products"));
    var markers = products.map((item,idx) => {
            var boundaries = item.boundary.split(',');
    var location = {
        lat:parseFloat(boundaries[0]),
        lng:parseFloat(boundaries[1])
    }
    return new google.maps.Marker({
        position: location,
        label: item.productName
    });
});
    // Add a marker clusterer to manage the markers.
    var markerCluster = new MarkerClusterer(map, markers,
        {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
}
function loadDoc(page) {
    $.ajax({
        url:'http://localhost:8080/api/products/?page='+page,
        dataType: 'JSONP',
        jsonpCallback: 'callback',
        type: 'GET',
        success: function(data) {
            localStorage.setItem('total',data.numberOfResults);
            localStorage.setItem('products',JSON.stringify(data.products));
            initMap();
            window.buildcontent();
        }
    });
}
$( document ).ready(function() {
    window.loadDoc(1);
    window.buildPager();
});