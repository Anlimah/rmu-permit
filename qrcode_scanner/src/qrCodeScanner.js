qrcode = window.qrcode;

const video = document.createElement("video");
const canvasElement = document.getElementById("qr-canvas");
const canvas = canvasElement.getContext("2d");

const qrResult = document.getElementById("qr-result");
const outputData = document.getElementById("outputData");
const btnScanQR = document.getElementById("btn-scan-qr");
const qrInputText = document.getElementById("qr_text");

var qrResultsContainer = document.getElementById("qr-results-container");
var qrRoot = document.getElementById("root");

let scanning = false;

qrcode.callback = res => {
  if (res) {
    outputData.innerText = res;
    qrInputText.value = res;
    qrInputText.dispatchEvent(new Event('change'));
    //set the input field to focus so that jquery can pick it
    // document.querySelector(".content").style.setProperty("border-color", "blue");
    scanning = false;
    video.srcObject.getTracks().forEach(track => {
      track.stop();
    });
    qrResult.hidden = true;
    canvasElement.hidden = true;
    btnScanQR.hidden = false;
  }
};

btnScanQR.onclick = () => {
  navigator.mediaDevices
    .getUserMedia({ video: { facingMode: "environment" } })
    .then(function(stream) {
      scanning = true;
      qrResult.hidden = true;
      btnScanQR.hidden = true;
      canvasElement.hidden = false;
      video.setAttribute("playsinline", true); // required to tell iOS safari we don't want fullscreen
      video.srcObject = stream;
      video.play();
      tick();
      scan();
    });
};

function tick() {
  canvasElement.height = video.videoHeight;
  canvasElement.width = video.videoWidth;
  canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);

  scanning && requestAnimationFrame(tick);
}

function scan() {
  try {
    qrcode.decode();
  } catch (e) {
    setTimeout(scan, 300);
  }
}

function closResults(){
  qrResultsContainer.style.display = "none";
  qrRoot.style.display = "block";
}
