

if (window.location.href.indexOf('crear-usuario') > -1) {

    function handleUploadFile() {
        document.querySelector('#avatar').click();
    }

    const divP = document.querySelector('#insert-image');
    let newDiv = document.createElement('div');
    newDiv.className = 'icon-image-insert d-flex align-items-center mx-auto';
    newDiv.id = 'div-icon-image';
    newDiv.innerHTML = `
    <div style="width: 30%;  margin: 0 auto">
        <i class="far fa-image" style="font-size: 60px; color: gray;"></i>
    </div>
`
    divP.append(newDiv);
    function handleChange(e) {
        // console.log(e.files);
        let reader = new FileReader();
        const fileName = e.files[0];
        reader.readAsDataURL(fileName);
        reader.onload = function () {
            const divP = document.querySelector('#insert-image');
            let divLast = document.querySelector('#div-icon-image');
            let newDiv = document.createElement('div');
            newDiv.style.width = '200px';
            newDiv.style.height = '150px';
            newDiv.className = 'd-flex mx-auto';
            newDiv.innerHTML = `
            <img src="${reader.result}" alt='file-selected' width="100%" height="100%"/>
            <i id="delete-file" class="fas fa-times text-danger ml-2" style="font-size: 20px;"></i>
        `;
            divP.replaceChild(newDiv, divLast);
            if (reader.result) {
                document.getElementById('delete-file').style.cursor = 'pointer';
                document.getElementById('delete-file').onclick = (e) => {
                    document.getElementById('avatar').value = "";
                    divP.replaceChild(divLast, newDiv);
                }
            }
        }
    }

}