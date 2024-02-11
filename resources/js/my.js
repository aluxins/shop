/**
 * Функция реализует отправку из формы только измененных данных за счет добавления
 * свойства disabled к нетронутым элементам, значения которых не передаются.
 * Функция принимает имя класса формы. Функция будет применена ко всем найденным формам.
 * @param {string} cls
 */
window.onlyChangedData = function (cls) {
    // Находим все формы с классом cls
    let elements = document.querySelectorAll('form.'+cls);

    // Перебираем найденные формы
    for (let els of elements) {

        // Добавляем каждому элементу формы отслеживание события изменения - change
        // и измененному элементу добавляем класс changed.
        for (let el of els) {
            el.addEventListener("change", function () {
                el.classList.add("changed");
            });
        }

        // Добавляем форме отслеживание события submit и при наступлении
        // события устанавливаем неизмененным элементам формы свойство disabled.
        els.addEventListener("submit", async () => {
            for (let el of els) {
                if (!el.classList.contains("changed") && el.name[0] !== "_") {
                    el.disabled = true;
                }
            }
        });
    }
}

/**
 * Класс конвертации Timestamp в date time.
 */
window.ConvertTimestamp  = class ConvertTimestamp{
    /**
     * Инициализация. Поиск элементов с классом cls и конвертация содержимого innerText.
     * @param {string} cls
     * @param {string} type time (только время), date (только дата)
     */
    static init(cls, type = ''){
        let elements = document.querySelectorAll('.' + cls);
        if (elements.length > 0) {
            for (let els of elements) {

                (/^([0-9]{1,10})$/).test(els.innerText) ?
                els.innerText = ConvertTimestamp.convert(els.innerText, type)
                : els.innerText = 'It is not the Timestamp';
            }
        }

    }

    /**
     * Конвертация timestamp.
     * @param {string} timestamp
     * @param {string} type
     */
    static convert(timestamp, type= '') {
        let d = new Date(timestamp * 1000),
            yyyy = d.getFullYear(),
            mm = ('0' + (d.getMonth() + 1)).slice(-2),
            dd = ('0' + d.getDate()).slice(-2),
            h = ('0' + d.getHours()).slice(-2),
            min = ('0' + d.getMinutes()).slice(-2),
            time;

        switch (type) {
            case 'time':
                time = h + ':' + min;
                break;
            case 'date':
                time = dd + '.' + mm + '.' + yyyy;
                break;
            default:
                time = dd + '.' + mm + '.' + yyyy.toString().slice(2) + ' ' + h + ':' + min;
        }
        return time;
    }

}



/**
 * Класс корзины товаров.
 */
window.Cart  = class Cart{

    /**
     * Инициализация корзины.
     * @param {string} cls
     * @return {void}
     */
    static init(cls){

        // Определяем количество товаров в корзине и отображаем на иконке корзины.
        Cart.text(
            Cart.count(
                Cart.cookie('cart')
            )
        );

        // Событие добавления товаров в корзину.
        Cart.add(cls);

        // Добавляем событие рендера корзины при ее открытии.
        let elem = document.querySelector("div.cart-button button");
        elem.addEventListener("click", function () {
            let cart = Cart.cookie('cart');
            Cart.render(cart);
        });
    }

    /**
     * Метод добавления товаров в корзину.
     * Выполняется перехват формы и отправка данных на сервер через HTTP-клиент axios.
     * @param {string} cls
     */
    static add(cls) {

        // Находим все формы с классом cls
        let elements = document.querySelectorAll('form.' + cls);

        // Для перехвата отправки формы добавляем отслеживание события - submit
        if (elements.length > 0) {
            for (let els of elements) {

                let data = window.getCookie('cart', 'json');
                let product = els.querySelector('input[name=product]');
                let quantity = els.querySelector('input[name=quantity]');

                // Определяем присутствие товара в корзине и добавляем фон полю quantity.
                let addCart = data[product.value];
                if(addCart){
                    quantity.value = addCart;
                    quantity.classList.add(
                        quantity.dataset.add
                    );
                }

                // Событие нажатия на кнопку добавления товара в корзину.
                els.addEventListener("submit", function (e) {
                    e.preventDefault();

                    // Добавляем событие изменения значения поля quantity.
                    Cart.change(e.target['quantity'], product.value);

                    // Создаем объект данных.
                    let values = {
                        'product': e.target['product']['value'],
                        'quantity': e.target['quantity']['value']
                    }

                    // Добавляем фон полю quantity.
                    if(e.target['quantity']['value'] < 1)
                        e.target['quantity'].classList.remove( e.target['quantity'].dataset.add );
                    else
                        e.target['quantity'].classList.add( e.target['quantity'].dataset.add );

                    // Записываем Cookie.
                    let cartObj = Cart.cookie('cart', values, 'add');

                    Cart.text(Cart.count(cartObj));

                    return false;
                });
            }
        }
    }

    /**
     * Метод вычисляет сумму значений объекта.
     * @param {object} cartObj
     * @return {number}
     */
    static count(cartObj) {
        const sumValues = obj => Object.values(obj).reduce((a, b) => parseInt(''+a) + parseInt(''+b), 0);
        return sumValues(cartObj);
    }

    /**
     * Количество товаров в корзине.
     * @return {void}
     */
    static text(number) {
        let elem = document.querySelector("div.cart-button button span");
        if(elem) elem.innerText = number > 0 ? number : '';
    }

    /**
     * Удаление товара из корзины.
     * @param {int} id
     */
    static remove(id) {
        // Создаем объект данных.
        let values = {
            'product': id,
            'quantity': 0
        }
        // Записываем Cookie
        Cart.cookie('cart', values, 'remove');

        let cart = Cart.cookie('cart');
        Cart.text(Cart.count(cart));
        Cart.render(cart);
    }

    /**
     * Обработка Cookie корзины товаров.
     * @param {*} cookieName
     * @param {{product, quantity}} data
     * @param {'add', 'remove', ''} type
     * @return {object, boolean}
     */
    static cookie(cookieName, data= {}, type= '') {
        if (navigator.cookieEnabled) {
            // Считывание Cookie.
            let oldData = window.getCookie(cookieName, 'json');

            // Изменение или добавление данных. Если количество меньше 1, тогда - удаление.
            if (type === 'add') {
                if(data['quantity'] < 1)delete oldData[data['product']];
                else oldData[data['product']] = data['quantity'];
            }

            // Удаление данных.
            else if (type === 'remove')
                delete oldData[data['product']];

            // Установка Cookie.
            if (type === 'add' || type === 'remove')
                window.setCookie(cookieName, oldData, 'json');

            return oldData;
        }
        return false;
    }

    /**
     * Метод рендера корзины товаров.
     * @param {object} data
     * @return {void}
     */
    static render(data){
        // Объект-шаблон товара
        let pattern = document.querySelector("div.cart-button ul li");

        // Отчистка списка товаров.
        document.querySelectorAll("div.cart-button ul li.flex").forEach(e => e.remove());
        document.querySelector("div.cart-order").classList.add('hidden');
        pattern.classList.remove('hidden');

        if(Object.keys(data).length !== 0) {
            // Подготавливаем данные
            let dataServer = {}
            for (let el in data) {
                dataServer[el] = {
                    'product': el,
                    'quantity': data[el]
                };
            }

            // Отправляем запрос для наполнения корзины товарами по шаблону.
            let response = Cart.server({'products': dataServer});
            response.then(function (response) {

                pattern.classList.add('hidden');

                let total = 0;
                let sale = 0;
                let full = 0;
                for (let el in response.data) {
                    // Создаем новый объект-шаблон.
                    let newPattern = pattern.cloneNode(true);

                    // Наполняем объект-шаблон данными.
                    // Class
                    newPattern.classList.remove('hidden');
                    newPattern.classList.add('flex');
                    newPattern.querySelector("div.hidden").classList.remove('hidden');

                    // URL
                    newPattern.querySelector("h3 a").href = response.data[el]['path_products'] + '/' + response.data[el]['id'];

                    // Name
                    newPattern.querySelector("h3 a").innerText = response.data[el]['name'];

                    // Price
                    newPattern.querySelectorAll("p")[0].innerHTML =  (parseFloat(response.data[el]['price']) * data[response.data[el]['id']]).toFixed(2);

                    // Old price
                    if(response.data[el]['old_price'] > 0 && response.data[el]['old_price'] > response.data[el]['price']) {
                        newPattern.querySelectorAll("p")[0].classList.add('text-red-500');
                        newPattern.querySelectorAll("p")[1].innerHTML = (parseFloat(response.data[el]['old_price']) * data[response.data[el]['id']]).toFixed(2);
                        sale += (parseFloat(response.data[el]['old_price']) - parseFloat(response.data[el]['price'])) * data[response.data[el]['id']];
                        full += parseFloat(response.data[el]['old_price']) * data[response.data[el]['id']];
                    }
                    else full += parseFloat(response.data[el]['price']) * data[response.data[el]['id']];

                    // Article
                    newPattern.querySelectorAll("p")[2].innerText = response.data[el]['article'];

                    // Quantity
                    newPattern.querySelector("input").value = data[response.data[el]['id']] <= response.data[el]['available'] ?
                        data[response.data[el]['id']] : response.data[el]['available'];
                    newPattern.querySelector("input").max = response.data[el]['available'];
                    if(response.data[el]['available'] < 1) newPattern.querySelector("input").min = 0;

                    Cart.change(newPattern.querySelector("input"), response.data[el]['id']);

                    // Image
                    newPattern.querySelector("img").src = response.data[el]['path_images'] + '' + Object.keys(JSON.parse(String(response.data[el]['images'])))[0];
                    newPattern.querySelector("img").alt = response.data[el]['name'];

                    // Remove
                    newPattern.querySelector("button").addEventListener("click", function() {
                        Cart.remove(response.data[el]['id']);
                    }, false);

                    // Добавляем новый объект-шаблон товара в DOM.
                    pattern.after(newPattern);

                    total += parseFloat(response.data[el]['price']) * data[response.data[el]['id']];
                }

                // Full
                document.querySelector("div.cart-button p.full").innerHTML = full.toFixed(2);

                // Sale
                document.querySelector("div.cart-button p.sale").innerHTML = -(sale.toFixed(2));

                // Total
                if (total > 0) {
                    document.querySelector("div.cart-button p.total").innerHTML = total.toFixed(2);
                    document.querySelector("div.cart-order").classList.remove('hidden');
                }
                document.querySelector("div.cart-button h1").classList.add('hidden');
            })
                .catch(function (error) {
                    console.log(error);
                });
        }
        else{
            pattern.classList.add('hidden');
            document.querySelector("div.cart-button h1").classList.remove('hidden');
        }
    }

    /**
     * Метод change поля quantity.
     * @param {object} obj
     * @param {int} product
     * @return {void}
     */
    static change(obj, product){
        obj.addEventListener("change", function (e) {
            // Устанавливаем фон.
            if(e.target['value'] < 1) obj.classList.remove(obj.dataset.add);
            else obj.classList.add(obj.dataset.add);

            // Создаем объект данных.
            let values = {
                'product': product,
                'quantity': e.target['value']
            }

            // Записываем Cookie.
            let cartObj = Cart.cookie('cart', values, 'add');

            // Изменяем количество товаров в корзине.
            Cart.text(Cart.count(cartObj));

            // Рендер корзины товаров.
            Cart.render(cartObj);
        });
    }

    /**
     * Отправка данных на сервер через HTTP-клиент axios.
     * @param {{product, quantity}} values
     */
    static server(values){
        // Выполняем отправку данных
        return axios({
            url: '/cart',
            method: 'post',
            timeout: 15000,
            headers: {'Content-Type': 'application/json'},
            data: JSON.stringify(values)
        })
    }
}

/**
 * Установка Cookie в браузере.
 * @param {string} name
 * @param {*} value
 * @param {'json' || 'string'} type
 * @param {number} expires
 * @param {string} path
 * @param {string} domain
 * @param {string} secure
 * @return {boolean}
 */
window.setCookie = function(name, value, type = 'string', expires= 1,
                            path= '/', domain= '', secure= '') {
    try {
        let cookieDate = new Date();
        cookieDate.setFullYear(cookieDate.getFullYear() + expires);
        let str = (type === 'json') ? name + '=' + JSON.stringify(value) : name + '=' + value;
        if (expires) str += '; expires=' + cookieDate.toUTCString();
        if (path) str += '; path=' + path;
        if (domain) str += '; domain=' + domain;
        if (secure) str += '; secure';
        document.cookie = str;
        return true;
    }
    catch {}
    return false;
}


/**
 * Поиск Cookie по имени.
 * В случае успеха функция возвращает строковое значение искомой Cookie, иначе пустую строку.
 * В зависимости от параметра type преобразует строку в JSON-объект {productId : quantity},
 * в случае неудачи возвращает пустой объект.
 * @param {string} name
 * @param {'json' || 'string'} type
 * @return {object, string}
 */
window.getCookie = function(name, type = 'string') {
    const regex = new RegExp('(^| )' + name + '=([^;]+)');
    const match = document.cookie.match(regex);
    if (match) {
        try {
            return type === 'json' ? JSON.parse(match[2]) : match[2];
        }
        catch {}
    }
    return type === 'json' ? {} : '';
}
