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
 * Класс корзины товаров.
 */
window.Cart  = class Cart{

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
     * Функция добавления товаров в корзину.
     * Выполняется перехват формы и отправка данных на сервер через HTTP-клиент axios.
     * @param {string} cls
     */
    static add(cls) {

        // Находим все формы с классом cls
        let elements = document.querySelectorAll('form.' + cls);

        // Для перехвата отправки формы добавляем отслеживание события - submit
        if (elements.length > 0) {
            for (let els of elements) {
                els.addEventListener("submit", function (e) {
                    e.preventDefault();

                    // Создаем объект данных.
                    let values = {
                        'product': e.target['product']['value'],
                        'quantity': e.target['quantity']['value']
                    }

                    // Записываем Cookie.
                    let cartObj = Cart.cookie('cart', values, 'add');

                    let count = Cart.count(cartObj);
                    if(count > 0) {
                        Cart.text(count);

                        // Отправка данных на сервер.
                        // Cart.server(values);
                    }

                    return false;
                });
            }
        }
    }

    /**
     * Функция вычисляет сумму значений объекта.
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
    static delete(id) {
        // Создаем объект данных.
        let values = {
            'product': id,
            'quantity': 0
        }
        // Записываем Cookie
        Cart.cookie('cart', values, 'add');
    }

    /**
     * Обработка Cookie корзины товаров.
     * @param {*} cookieName
     * @param {{product, quantity}} data
     * @param {'add', 'delete', ''} type
     * @return {object, boolean}
     */
    static cookie(cookieName, data= {}, type= '') {
        if (navigator.cookieEnabled) {
            // Считывание Cookie.
            let oldData = window.getCookie(cookieName, 'json');

            // Изменение или добавление данных.
            if (type === 'add')
                oldData[data['product']] = data['quantity'];

            // Удаление данных.
            else if (type === 'delete')
                delete oldData[data['product']];

            // Установка Cookie.
            if (type === 'add' || type === 'delete')
                window.setCookie(cookieName, oldData, 'json');

            return oldData;
        }
        return false;
    }

    /**
     * Функция рендера корзины товаров.
     * @param {object} data
     * @return {void}
     */
    static render(data){
        let pattern = document.querySelector("div.cart-button ul li");
        //for (let el in data) {
        //    console.log(data[el]);
        //}
        Cart.server(data);
    }

    /**
     * Отправка данных на сервер через HTTP-клиент axios.
     * @param {{product, quantity}} values
     */
    static server(values){
        // Выполняем отправку данных
        axios({
            url: '/cart',
            method: 'post',
            timeout: 3000,
            headers: {'Content-Type': 'application/json'},
            data: JSON.stringify(values)
        })
            .then(function (response) {
                console.log(response.data);
            })
            .catch(function (error) {
                console.log(error);
            });
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
                            path= '', domain= '', secure= '') {
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
 * В зависимости от параметра type преобразует строку в JSON-объект, в случае неудачи возвращает пустой объект.
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
