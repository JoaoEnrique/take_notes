
$(document).ready(function() {
    image_upload_account() // PREVIEW DE IMAGEM DA CONTA
    image_upload_message_team() // PREVIEW DE IMAGEM DA CONTA
    video_upload_message_team() // PREVIEW DE IMAGEM DA CONTA
    showPdfPreview()

    // EFEITO APARECER

    document.querySelectorAll(".show-item").forEach((animacao, index) => {
        if(animacao.getBoundingClientRect().top >= -500 && animacao.getBoundingClientRect().top < window.innerHeight){
            animacao.classList.add("efeitoScroll")
        }else{
            animacao.classList.remove("efeitoScroll") 
        }
    })
});


//BOTÃO PARA MOSTRAR SENHA    
function showPassword() {//Botao de olho para mostrar e esconder a senha (pagina entrar)
    var senha = document.querySelector("#password");
    var imgShow = document.querySelector("#view-password");
    if (senha.type === "password") {
        senha.type = "text";
        imgShow.src = "../img/eye-off.svg"
    } else {
        senha.type = "password";
        imgShow.src = "../img/eye.svg"
    }
}

//BOTÃO PARA MOSTRAR CONFIRMAÇÃO DE SENHA    
function showPasswordConfirm() {//Botao de olho para mostrar e esconder a senha (pagina entrar)
    var senha = document.querySelector("#password_confirmation");
    var imgShow = document.querySelector("#view-password-confirm");
    if (senha.type === "password") {
        senha.type = "text";
        imgShow.src = "../img/eye-off.svg"
    } else {
        senha.type = "password";
        imgShow.src = "../img/eye.svg"
    }
}

// PREVIEW DA IMAGEM DA CONTA
function image_upload_account(){
    imageUpload = document.querySelector('.img-account-preview'); //campo de imagem
  
    //caso tenha escolhido uma imagem
    if(imageUpload){
        // Listen for changes in the input file
        imageUpload.addEventListener('change', function() {
            imagemProfile = document.getElementById('label-img');
        // Get the selected file
        const file = this.files[0];
        
        // Check if a file is selected
        if (file) {
            // Create a FileReader object
            const reader = new FileReader();
        
            // Set up the reader to load the image
            reader.onload = function(e) {
                imagemProfile.style.backgroundImage = "url('" + e.target.result + "')" 
            //   previewContainer.appendChild(img);
            };
        
            // Read the selected file as a Data URL
            reader.readAsDataURL(file);
        }
        });
    }
}


function image_upload_message_team(){
    imageUpload = document.querySelector('#img'); //campo de imagem
  
    //caso tenha escolhido uma imagem
    if(imageUpload){
        imagemProfile = document.getElementById('preview-img');
        // Listen for changes in the input file
        imageUpload.addEventListener('change', function() {
        // Get the selected file
        const file = this.files[0];
        
        // Check if a file is selected
        if (file) {
            // Create a FileReader object
            const reader = new FileReader();
        
            // Set up the reader to load the image
            reader.onload = function(e) {
                img_path = e.target.result



                document.querySelector('.img-preview-message-team').src = e.target.result
                document.querySelector('.img-preview-message-team-dois').src = e.target.result

                img_path = document.querySelector('.img-preview-message-team-dois');

                if (img_path.width > img_path.height) {
                    imagemProfile.classList.add('div-img-preview-message-team-horizontal');
                    imagemProfile.classList.remove('div-img-preview-message-team-vertical');
                    imagemProfile.classList.remove('div-img-preview-message-team-quadrado');
                    console.log('h')
                } else if (img_path.width < img_path.height) {
                    imagemProfile.classList.add('div-img-preview-message-team-vertical');
                    imagemProfile.classList.remove('div-img-preview-message-team-horizontal');
                    imagemProfile.classList.remove('div-img-preview-message-team-quadrado');
                    console.log('v')
                }else{
                    imagemProfile.classList.add('div-img-preview-message-team-quadrado');
                    imagemProfile.classList.remove('div-img-preview-message-team-horizontal');
                    imagemProfile.classList.remove('div-img-preview-message-team-vertical');
                    console.log('q')
                }

                imagemProfile.style.display = "block"
                // imagemProfile.style.backgroundImage = "url('" + e.target.result + "')" 
            //   previewContainer.appendChild(img);
            };
        
            // Read the selected file as a Data URL
            reader.readAsDataURL(file);
        }
        });
    }
}

function video_upload_message_team(){
    videoUpload = document.querySelector('#video'); //campo de imagem
  
    //caso tenha escolhido uma imagem
    if(videoUpload){
        videoProfile = document.getElementById('preview-video');
        // Listen for changes in the input file
        videoUpload.addEventListener('change', function() {
        // Get the selected file
        const file = this.files[0];
        
        // Check if a file is selected
        if (file) {
            // Create a FileReader object
            const reader = new FileReader();
        
            // Set up the reader to load the image
            reader.onload = function(e) {
                document.querySelector('.video-preview-message-team').src = e.target.result

                videoProfile.style.display = "block"
                // imagemProfile.style.backgroundImage = "url('" + e.target.result + "')" 
            //   previewContainer.appendChild(img);
            };
        
            // Read the selected file as a Data URL
            reader.readAsDataURL(file);
        }
        });
    }
}


function showPdfPreview() {
    const fileInput = document.getElementById('file');

    if(fileInput){
        fileInput.addEventListener('change', function() {
            const pdfPreview = document.getElementById('pdf-preview');
            const pdfName = document.getElementById('pdf-name');
            const pdfSize = document.getElementById('pdf-size');
            // Verifica se um arquivo foi selecionado
            if (fileInput.files.length > 0) {
                const selectedFile = fileInput.files[0];
                
                // Atualiza o nome do arquivo no preview
                pdfName.textContent = selectedFile.name;
        
                // Calcula o tamanho do arquivo em megabytes
                const fileSizeInMB = (selectedFile.size / (1024 * 1024)).toFixed(2);
                pdfSize.textContent = `Tamanho: ${fileSizeInMB} MB`;
        
                // Exibe o preview
                pdfPreview.style.display = 'flex';
            }
        })
    }
}


// PREVIEW DO VIDEO
function video_upload(){
    // PREVIEW DA IMAGEM DO POST
    // Get the input file element
    imageUpload = document.getElementById('video');
    
    
    if(imageUpload){
        // Listen for changes in the input file
        imageUpload.addEventListener('change', function() {
        // Get the selected file
        const file = this.files[0];
        
        // Check if a file is selected
        if (file) {
            // Create a FileReader object
            const reader = new FileReader();
        
            // Set up the reader to load the image
            reader.onload = function(e) {
            // Create an image element
            //   const img = document.createElement('img');
        
            // Set the source of the image to the loaded file
            //   img.src = e.target.result;
            // Append the image to the preview container
            const previewContainer = document.querySelector('.label-video');
            const videoPost = document.querySelector('.video-post');
            previewContainer.style.display = 'block';
            videoPost.src = e.target.result;
            //   previewContainer.appendChild(img);
            };
        
            // Read the selected file as a Data URL
            reader.readAsDataURL(file);
        }
        });
    }
}

//EFEITO APARECER
window.addEventListener("scroll", () => {
    document.querySelectorAll(".show-item").forEach((animacao, index) => {
        if(animacao.getBoundingClientRect().top >= -500 && animacao.getBoundingClientRect().top < window.innerHeight){
            animacao.classList.add("efeitoScroll")
        }else{
            animacao.classList.remove("efeitoScroll") 
        }
    })
})