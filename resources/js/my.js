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

                    if(cartObj) {
                        let count = Cart.count(cartObj);
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
     */
    static count(cartObj) {
        const sumValues = obj => Object.values(obj).reduce((a, b) => parseInt(''+a) + parseInt(''+b), 0);
        return sumValues(cartObj);
    }

    /**
     * Количество товаров в корзине.
     */
    static text(number) {
        let elem = document.querySelector("button.cart-button span");
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
     * @param {string} type
     */
    static cookie(cookieName, data, type) {
        if (navigator.cookieEnabled) {
            // Считывание Cookie.
            let oldData = window.getCookie(cookieName);

            // Изменение или добавление данных.
            if (type === 'add')
                oldData[data['product']] = data['quantity'];

            // Удаление данных.
            else if (type === 'delete')
                delete oldData[data['product']];

            // Установка Cookie.
            window.setCookie(cookieName, oldData, 1, '', '', '');

            return oldData;
        }
        return false;
    }

    /**
     * Отправка данных на сервер через HTTP-клиент axios.
     * @param {{product, quantity}} values
     */
    static server(values){
        // Выполняем отправку данных
        axios({
            url: '/cart/add',
            method: 'post',
            timeout: 3000,
            headers: {'Content-Type': 'application/json'},
            data: JSON.stringify(values)
        })
            .then(function (response) {
                console.log(response);
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
 * @param {number} expires
 * @param {string} path
 * @param {string} domain
 * @param {string} secure
 */
window.setCookie = function(name, value, expires, path, domain, secure) {
    if (!name) return false;
    let cookieDate = new Date();
    cookieDate.setFullYear(cookieDate.getFullYear() + expires);
    let str = name + '=' + JSON.stringify(value);
    if (expires) str += '; expires=' + cookieDate.toUTCString();
    if (path)    str += '; path=' + path;
    if (domain)  str += '; domain=' + domain;
    if (secure)  str += '; secure';
    document.cookie = str;
    return true;
}


/**
 * Поиск Cookie по имени.
 * В случае успеха функция возвращает JSON-объект искомой Cookie, иначе пустой объект.
 * @param {string} name
 */
window.getCookie = function(name) {
    let pattern = "(?:; )?" + name + "=([^;]*);?";
    let regexp  = new RegExp(pattern);
    if (regexp.test(document.cookie))
        return JSON.parse(RegExp["$1"]);
    return {};
}
