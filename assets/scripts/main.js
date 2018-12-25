'use strict';

// Scripts for the profile-page
(function(){
  if(document.querySelector('.user-profile')){
    const clickableText            = document.querySelector('.user-profile .img-change');
    const innerProfileImgContainer = document.querySelector('.user-profile .profile-img-container .inner-profile-img-container');
    const profileImgForm           = document.querySelector('.user-profile .profile-img-form');
    let   profileImgInput          = document.querySelector('.user-profile #image');
    const profileImg               = document.querySelector('.profile-img-container img');


    clickableText.addEventListener('click', () => openProfileImgForm());
    innerProfileImgContainer.addEventListener('click', () => openProfileImgForm());

    function openProfileImgForm(){
      profileImgInput.click();
    };

    profileImgForm.addEventListener('change', () => {
      profileImgForm.submit();
    });
  }

  if(document.querySelector('.create-post-form')){
    const img = document.querySelector('#img-preview-input');
    const imgInput = document.querySelector('form.create-post-form input#image');
    const inputBtn = document.querySelector('#img-preview-input + div.btn');

    img.addEventListener('click', () => openProfileImgForm());
    inputBtn.addEventListener('click', () => openProfileImgForm());

    function openProfileImgForm(){
      imgInput.click();
    };

    imgInput.addEventListener('change', () => {
      if(imgInput.files && imgInput.files[0]){
        img.setAttribute('src',
        window.URL.createObjectURL(imgInput.files[0])
        );
      }
    });
  }
})();
