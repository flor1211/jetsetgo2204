var form = document.getElementById("addPlaneForm"); 
    imgInput = document.querySelector(".imgHolder img"),
    file = document.getElementById("imgInput"),
    uploadLabel = document.getElementById("uploadLabel"),
    planeID = document.getElementById("planeID"),
    numseats = document.getElementById("numseats"),
    planestatus = document.getElementById("status"),
    subminBtn = document.querySelector(".submit"),
    userInfo = document.getElementById("data"),
    modal = document.getElementById("planeForm"),
    modalTitle = document.querySelector("#planeForm .modal-title")


let getData = localStorage.getItem('userProfile') ? JSON.parse(localStorage.getItem('userProfile')) : [];

let isEdit = false, editId;

file.onchange = function() {
    if (file.files[0].size < 1000000) {
        var fileReader = new FileReader();

        fileReader.onload = function(e) {
            var imgUrl = e.target.result;
            imgInput.src = imgUrl; 
        }
        fileReader.readAsDataURL(file.files[0]);

    } else {
        alert('This file is too large');
    }
}


form.addEventListener('submit', (e) => {
    e.preventDefault();

    const information = {
        picture: !imgInput.src ? "./assets/images/planeupload.png" : imgInput.src,
        pID: planeID.value,
        pSeats: numseats.value,
        pStatus: planestatus.value,
    };

    if (!isEdit) {
        getData.push(information);
    } else {
        isEdit = false;
        getData[editId] = information;
    }

    localStorage.setItem('userProfile', JSON.stringify(getData));

    subminBtn.innerText = "Submit"
    modalTitle.innerHTML = "New Plane"


    showInfo()

    form.reset()

    imgInput.src = "./assets/images/planeupload.png"
    modal.style.display = "none"

    document.querySelector(".modal-backdrop").remove()

});


