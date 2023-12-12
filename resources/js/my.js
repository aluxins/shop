/**
 * Функция реализует отправку из формы только измененных данных за счет добавления
 * свойства disabled к нетронутым элементам, значения которых не передаются.
 * Функция принимает имя класса формы. Функция будет применена ко всем найденным формам.
 * @param {string} cls
 */
window.onlyChangedData = function (cls) {
    // Находим все формы с классом cls
    let srhf = document.querySelectorAll('form.'+cls);

    // Перебираем найденные формы
    for (let els of srhf) {

        // Добавляем каждому элементу формы отслеживание события изменения - change
        // и измененному элементу добавляем класс changed.
        for (let el of els) {
            el.addEventListener("change", function () {
                el.classList.add("changed");
            });
        }

        // Добавляем форме отслеживание собития submit и при наступлении
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

window.addClassList = function(idElement, list) {

    const element = document.getElementById(idElement);
    element.classList.add(...list);
}
