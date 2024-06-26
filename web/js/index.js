function addCart(id_product) {
    $.ajax({
        method: "GET",
        url: `/cart/create?id_product=${id_product}`,
    })
        .done(function (message) {
            updateCartCount();
            $.pjax.reload({ container: '#cart' });
            $('.info').html(message).fadeIn().animate({ opacity: 1.0 }, 3000).fadeOut("slow");
        });
}

// Удаление товара из корзины
function removeCart(id_product) {
    $.ajax({
        method: "POST",
        url: `/cart/remove?id_product=${id_product}`,
    })
        .done(function (message) {
            updateCartCount();
            $.pjax.reload({ container: '#cart' });
            $('.info').html(message).fadeIn().animate({ opacity: 1.0 }, 3000).fadeOut("slow");
        });
}

function deleteCart(id_product) {
    $.ajax({
        method: "POST",
        url: `/cart/delete?id_product=${id_product}`,
    })
        .done(function (message) {
            updateCartCount();
            $.pjax.reload({ container: '#cart' });
            $('.info').html(message).fadeIn().animate({ opacity: 1.0 }, 3000).fadeOut("slow");
        });
}

function byOrder() {
    $.ajax({
        method: "GET",
        url: `/cart/by-order`,
    })
        .done(function (message) {
            if (message == "Заказ сформирован") {
                updateCartCount();
                window.location.href = '/cart/succes';
            } else {
                updateCartCount();
                $.pjax.reload({ container: '#cart' });
                $('.info').html(message).fadeIn().animate({ opacity: 1.0 }, 3000).fadeOut("slow");

            }

        });
}
//cart over

//prodpage

function addCartButtonClick(id_product, button) {
    button.innerHTML = 'В корзине';
    button.disabled = true;
    button.classList.add('in-cart-prod-page')
    $.ajax({
        method: "GET",
        url: `/cart/create?id_product=${id_product}`,
    })
        .done(function () {
            updateCartCount();
        });
}

function toCartClick(id_product) {
    $.ajax({
        method: "GET",
        url: `/cart/create?id_product=${id_product}`,
    }).done(function () {
        updateCartCount();
    });

    let price = document.querySelector('.price').textContent
    document.querySelector('.price-block').innerHTML = `
    <p class="price">${price}</p>
    <a href = '/cart' class="link-to-cart">Перейти в корзину</a>`
    document.querySelector('.price-block').style = "transition: all 0.4s"
    document.querySelector('.price-block').style.height = '160px'
}

function updateCartCount() {
    $.ajax({
        method: "GET",
        url: "/cart/cart-count",
    })
        .done(function (count) {
            if (count > 0) {
                $('#cart-count').text(count).css('transform', 'scale(1)'); // Показываем счетчик, если есть товары в корзине
            } else {
                $('#cart-count').css('transform', 'scale(0)'); // Скрываем счетчик, если корзина пуста
            }
        })
        .fail(function () {
            $('#cart-count').css('transform', 'scale(0)'); // Скрываем счетчик в случае ошибки AJAX-запроса
        });
}

// Вызываем функцию для первоначальной загрузки при загрузке страницы
$(document).ready(function () {
    updateCartCount(); // Вызываем обновление счетчика
});

// Вызываем функцию для первоначальной загрузки при загрузке страницы
$(document).ready(function () {
    // Пытаемся получить значение счетчика из сессии
    var savedCount = sessionStorage.getItem('cartItemCount');
    if (savedCount !== "null" && savedCount !== '0' && savedCount !== null) {
        $('#cart-count').css('transform', 'scale(1)'); // Показываем сохраненное значение счетчика
    }

    // Проверяем, есть ли товары в корзине, перед тем как показать счетчик
    updateCartCount();
});

function categoryFilter(id_category) {
    let from = null;
    let until = null;
    sort = sorting.value
    if (f2) {
        from = f2.value;
    }
    if (f3) {
        until = f3.value;
    }
    const m = document.querySelectorAll(".mjs");
    let manufactures = "";
    if (m) {
        for (let i = 0; i < m.length; i++) {
            if (m[i].checked) {
                if (manufactures) {
                    manufactures += " ";
                }
                manufactures += m[i].dataset.id;
            }
        }
    }
    window.location.href = `/catalog/filter?id=${id_category}&f=${from}&u=${until}&m=${manufactures}&s=${sort}`;


}




