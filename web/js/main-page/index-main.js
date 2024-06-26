
$(".catalog-slider").slick({
  autoplay: true,
  autoplaySpeed: 4000, // Скорость прокрутки в миллисекундах
  speed: 700, // Скорость анимации перехода между слайдами
  cssEase: 'ease', // Тип анимации перехода
  infinite: true,
})

$(".promo-slider").slick({
  autoplay: true,
  autoplaySpeed: 7000, // Скорость прокрутки в миллисекундах
  speed: 900, // Скорость анимации перехода между слайдами
  cssEase: 'ease', // Тип анимации перехода
  infinite: true,
})


const sliderMain = new ItcSimpleSlider('.slider', {
  loop: true,
  autoplay: false,
  interval: 5000,
  swipe: true,

})


let prevBtnMain = document.createElement('button');
let nextBtnMain = document.createElement('button');
let indicatorsMain = document.querySelector('.itcss__indicators');
prevBtnMain.classList.add('btn-card')
prevBtnMain.classList.add('btn-prev')
nextBtnMain.classList.add('btn-card')
nextBtnMain.classList.add('btn-next')
indicatorsMain.insertAdjacentElement('beforebegin', prevBtnMain)
indicatorsMain.insertAdjacentElement('afterend', nextBtnMain)

document.querySelector('.btn-prev').onclick = () => {
    // перейдём к предыдущему слайду
    sliderMain.prev();
}
// назначим обработчик при нажатии на кнопку .btn-next
document.querySelector('.btn-next').onclick = () => {
    // перейдём к следующему слайду
    sliderMain.next();
}


