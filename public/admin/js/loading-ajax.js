let htmlLoading = `<div class="loading-ajax fixed-bottom d-flex justify-content-center">
<div class="lds-css ng-scope" style="margin: auto;">
<div class="lds-spinner" style="width:100%;height:100%"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
<style type="text/css">@keyframes lds-spinner {
  0% {
    opacity: 1;
  }
  100% {
    opacity: 0;
  }
}
@-webkit-keyframes lds-spinner {
  0% {
    opacity: 1;
  }
  100% {
    opacity: 0;
  }
}
.lds-spinner {
  position: relative;
}
.lds-spinner div {
  left: 94px;
  top: 50px;
  position: absolute;
  -webkit-animation: lds-spinner linear 1s infinite;
  animation: lds-spinner linear 1s infinite;
  background: #009c9f;
  width: 12px;
  height: 20px;
  border-radius: 40%;
  -webkit-transform-origin: 6px 50px;
  transform-origin: 6px 50px;
}
.lds-spinner div:nth-child(1) {
  -webkit-transform: rotate(0deg);
  transform: rotate(0deg);
  -webkit-animation-delay: -0.933333333333333s;
  animation-delay: -0.933333333333333s;
}
.lds-spinner div:nth-child(2) {
  -webkit-transform: rotate(24deg);
  transform: rotate(24deg);
  -webkit-animation-delay: -0.866666666666667s;
  animation-delay: -0.866666666666667s;
}
.lds-spinner div:nth-child(3) {
  -webkit-transform: rotate(48deg);
  transform: rotate(48deg);
  -webkit-animation-delay: -0.8s;
  animation-delay: -0.8s;
}
.lds-spinner div:nth-child(4) {
  -webkit-transform: rotate(72deg);
  transform: rotate(72deg);
  -webkit-animation-delay: -0.733333333333333s;
  animation-delay: -0.733333333333333s;
}
.lds-spinner div:nth-child(5) {
  -webkit-transform: rotate(96deg);
  transform: rotate(96deg);
  -webkit-animation-delay: -0.666666666666667s;
  animation-delay: -0.666666666666667s;
}
.lds-spinner div:nth-child(6) {
  -webkit-transform: rotate(120deg);
  transform: rotate(120deg);
  -webkit-animation-delay: -0.6s;
  animation-delay: -0.6s;
}
.lds-spinner div:nth-child(7) {
  -webkit-transform: rotate(144deg);
  transform: rotate(144deg);
  -webkit-animation-delay: -0.533333333333333s;
  animation-delay: -0.533333333333333s;
}
.lds-spinner div:nth-child(8) {
  -webkit-transform: rotate(168deg);
  transform: rotate(168deg);
  -webkit-animation-delay: -0.466666666666667s;
  animation-delay: -0.466666666666667s;
}
.lds-spinner div:nth-child(9) {
  -webkit-transform: rotate(192deg);
  transform: rotate(192deg);
  -webkit-animation-delay: -0.4s;
  animation-delay: -0.4s;
}
.lds-spinner div:nth-child(10) {
  -webkit-transform: rotate(216deg);
  transform: rotate(216deg);
  -webkit-animation-delay: -0.333333333333333s;
  animation-delay: -0.333333333333333s;
}
.lds-spinner div:nth-child(11) {
  -webkit-transform: rotate(240deg);
  transform: rotate(240deg);
  -webkit-animation-delay: -0.266666666666667s;
  animation-delay: -0.266666666666667s;
}
.lds-spinner div:nth-child(12) {
  -webkit-transform: rotate(264deg);
  transform: rotate(264deg);
  -webkit-animation-delay: -0.2s;
  animation-delay: -0.2s;
}
.lds-spinner div:nth-child(13) {
  -webkit-transform: rotate(288deg);
  transform: rotate(288deg);
  -webkit-animation-delay: -0.133333333333333s;
  animation-delay: -0.133333333333333s;
}
.lds-spinner div:nth-child(14) {
  -webkit-transform: rotate(312deg);
  transform: rotate(312deg);
  -webkit-animation-delay: -0.066666666666667s;
  animation-delay: -0.066666666666667s;
}
.lds-spinner div:nth-child(15) {
  -webkit-transform: rotate(336deg);
  transform: rotate(336deg);
  -webkit-animation-delay: 0s;
  animation-delay: 0s;
}
.lds-spinner {
  width: 101px !important;
  height: 101px !important;
  -webkit-transform: translate(-50.5px, -50.5px) scale(0.505) translate(50.5px, 50.5px);
  transform: translate(-50.5px, -50.5px) scale(0.505) translate(50.5px, 50.5px);
}
</style></div>
    </div>`;
function loadingAjax() {
    $('body>.app-content.content .content-wrapper').prepend(htmlLoading);
}
function stopLoadingAjax() {
    $('body>.app-content.content .content-wrapper').find('.loading-ajax').remove();
}

$(document).bind("ajaxSend", function (event, jqxhr, settings) {
    loadingAjax();
}).bind("ajaxComplete", function () {
    stopLoadingAjax()
});

function goToDivById(id, top = 0, time = 500) {
    $('html, body').animate({
        scrollTop: $("#" + id).offset().top - top
    }, time)
}