document.querySelector(".active-tag").style.left = "0%"
document.querySelector(".toggle-char").addEventListener("click", this.toToggle);
document.querySelector(".more-button").addEventListener("click", this.toChars);



const slider = new ItcSimpleSlider('.itcss', {
    loop: true,
    autoplay: false,
    interval: 5000,
    swipe: true,

})



let prevBtn = document.createElement('button');
let nextBtn = document.createElement('button');
let indicators = document.querySelector('.itcss__indicators');
prevBtn.classList.add('btn-card')
prevBtn.classList.add('btn-prev')
nextBtn.classList.add('btn-card')
nextBtn.classList.add('btn-next')
indicators.insertAdjacentElement('beforebegin', prevBtn)
indicators.insertAdjacentElement('afterend', nextBtn)

document.querySelector('.btn-prev').onclick = () => {
    // перейдём к предыдущему слайду
    slider.prev();
}
// назначим обработчик при нажатии на кнопку .btn-next
document.querySelector('.btn-next').onclick = () => {
    // перейдём к следующему слайду
    slider.next();
}

function showMore() {
    var dots = document.getElementById("dots");
    var moreText = document.getElementById("more");
    var btn = document.querySelector(".desc-more-button");

    if (dots.style.display === "none") {
        dots.style.display = "inline";
        btn.innerHTML = "Читать Полностью";
        moreText.style.display = "none";
        btn.style = "align-self: flex-start;"
    } else {
        dots.style.display = "none";
        btn.textContent = "Свернуть";
        btn.style = "align-self: flex-end;";
        moreText.style.display = "inline";
    }
}

function toToggle() {
    const description = document.querySelector(".description-container");
    const chars = document.querySelector(".char-container");
    const activeTag = document.querySelector(".active-tag");
    description.classList.toggle("hide");
    chars.classList.toggle("hide");
    document.querySelector(".toggle-char p:nth-child(1)").classList.toggle("active-char");
    document.querySelector(".toggle-char p:nth-child(2)").classList.toggle("active-char");
    document.querySelector(".toggle-char p:nth-child(1)").classList.toggle("non-active-char");
    document.querySelector(".toggle-char p:nth-child(2)").classList.toggle("non-active-char");
    activeTag.style.left = activeTag.style.left === "0%" ? "50%" : "0%";
}

function toChars() {
    const activeTag = document.querySelector(".active-tag");
    if (activeTag.style.left !== "50%") {
        const description = document.querySelector(".description-container");
        const chars = document.querySelector(".char-container");

        description.classList.add("hide");
        chars.classList.remove("hide");
        document.querySelector(".toggle-char p:nth-child(1)").classList.remove("active-char");
        document.querySelector(".toggle-char p:nth-child(2)").classList.add("active-char");
        document.querySelector(".toggle-char p:nth-child(1)").classList.add("non-active-char");
        document.querySelector(".toggle-char p:nth-child(2)").classList.remove("non-active-char");
        activeTag.style.left = "50%";
    }

}

