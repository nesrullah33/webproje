<!DOCTYPE html>
<html lang="tr">
<head>
    <title>Nesrumell Hakkımda</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="iletisim.css">
</head>
<body>

<!-- navbar -->
<nav class="navbar sticky-top">
    <div class="container-fluid">
        <div class="row w-100 align-items-center">
            <div class="col-12 col-md-4">
                <h5 class="brand-name mb-0">Nesromell Tişört</h5>
            </div>
            <div class="col-12 col-md-8">
                <div class="d-flex flex-wrap justify-content-end gap-2">
                    <a href="index.html" class="btn btn-modern btn-orange">
                        Anasayfa
                    </a>
                    <a href="hakkimda.html" class="btn btn-modern btn-orange">
                        Hakkımda
                    </a>
                    <a href="iletisim.php" class="btn btn-modern btn-orange">
                        İletişim
                    </a>
                    <a href="https://wa.me/905523019582?text=Merhaba,%20nesrumell.com'dan%20geliyorum,%20bir%20şey%20sormak%20istiyorum." 
                    class="btn btn-modern btn-orange btn-whatsapp" target="_blank">
                     WhatsApp
                 </a>                 
                    <div class="dropdown">
                        <button class="btn btn-modern btn-orange" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-shopping-cart me-1"></i> Sepet
                            <span class="badge bg-danger ms-1" id="cart-count">0</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end p-3 cart-dropdown">
                            <div id="cart-items" class="mb-3">      
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <strong>Toplam:</strong>
                                <strong id="cart-total">$0.00</strong>
                            </div>
                            <button class="btn btn-success w-100">Sipariş Ver</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- iletişim formu db ye kayıt edil di mi edilmedi mi kontrol -->
<?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
    <div class="alert alert-success mt-3 w-25 d-flex mx-auto justify-content-center" role="alert">
      Talebiniz alındı teşekkürler!
    </div>
  <?php elseif (isset($_GET['status']) && $_GET['status'] == 'error'): ?>
    <div class="alert alert-danger mt-3 w-25 d-flex mx-auto justify-content-center" role="alert">
    Talebiniz alınırken bir hata oluştu. Lütfen tekrar deneyin.
    </div>
<?php endif; ?>


<!-- iletişim -->
<div class="contact-container">
    <div class="contact-header">
        <h1>İletişim</h1>
    </div>
    <form action="db_iletişim.php" method="post">
        <div class="form-group">
            <input type="text" class="form-input" placeholder="Ad Soyad" name="name" required>
        </div>

        <div class="form-group">
            <input type="email" class="form-input" placeholder="E-posta Adresi" name="email" required>
        </div>

        <div class="form-group">
            <textarea class="form-input" placeholder="Mesajınız..." required name="message"></textarea>
        </div>

        <button type="submit" class="submit-btn">Gönder</button>
    </form>
</div>

<!-- footer -->
<footer class="enhanced-footer">
    <div class="footer-top-border"></div>
    <div class="footer-content">
        <nav class="footer-nav">
            <a href="index.html">Anasayfa</a>
            <a href="hakkimda.html">Hakkımızda</a>
            <a href="iletisim.html">İletişim</a>
            <a href="https://wa.me/905523019582?text=Merhaba,%20nesrumell.com'dan%20geliyorum,%20bir%20şey%20sormak%20istiyorum." 
                    class="whatsapp-link" target="_blank">
                     WhatsApp
                   </a>
        </nav>
        <p class="copyright-text">
            © 2024 Tüm hakları <a href="https://nesrumell.com">nesrumell.com</a>'a aittir
        </p>
    </div>
</footer>


<!-- sepet kısmı-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js">

let cart = [];

function updateSize(sizeId, value) {
    document.getElementById(sizeId).textContent = value;
}

function addToCart(name, price, sizeId) {
    const size = document.getElementById(sizeId).textContent;
    const productKey = `${name}-${size}`;
    const existingItem = cart.find(item => item.productKey === productKey);
    
    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({
            productKey: productKey,
            name: name,
            price: price,
            size: size,
            quantity: 1
        });
    }
    updateCart();
}

function removeFromCart(index, event) {
    event.stopPropagation();
    cart.splice(index, 1);
    updateCart();
}

function updateQuantity(index, change, event) {
    event.stopPropagation();
    cart[index].quantity += change;
    if (cart[index].quantity < 1) {
        cart.splice(index, 1);
    }
    updateCart();
}

function updateCart() {
    const cartItems = document.getElementById('cart-items');
    const cartCount = document.getElementById('cart-count');
    const cartTotal = document.getElementById('cart-total');
    
    cartItems.innerHTML = '';
    let total = 0;
    let count = 0;
    
    cart.forEach((item, index) => {
        total += item.price * item.quantity;
        count += item.quantity;
        
        cartItems.innerHTML += `
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <h6 class="mb-0">${item.name} (${item.size})</h6>
                    <small>$${item.price}</small>
                </div>
                <div class="d-flex align-items-center">
                    <button class="btn btn-sm btn-outline-secondary me-2" onclick="updateQuantity(${index}, -1, event)">-</button>
                    <span>${item.quantity}</span>
                    <button class="btn btn-sm btn-outline-secondary ms-2" onclick="updateQuantity(${index}, 1, event)">+</button>
                    <button class="btn btn-sm btn-outline-danger ms-2" onclick="removeFromCart(${index}, event)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
    });
    
    cartCount.textContent = count;
    cartTotal.textContent = `$${total.toFixed(2)}`;
}
</script>

</body>
</html>
