'use strict';

(function(){

  // Scripts for the profile-page
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

  // Scripts for the avatar submit form
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

  // Scripts for posts
  if(document.getElementById('post-container')){
    const post_container = document.getElementById('post-container');
    const posts = post_container.querySelectorAll('section');

    posts.forEach((el) => {
      const id = el.querySelector('.post').dataset.id;
      const likeBtn = el.querySelector('.like');
      const dislikeBtn = el.querySelector('.dislike');
      const commentBtn = el.querySelector('.comment');

      const likeAlert = el.querySelector('.like-alert');
      const dislikeAlert = el.querySelector('.dislike-alert');
      const commentAlert = el.querySelector('.comment-alert');


      // When like btn is clicked
      likeBtn.addEventListener('click', (event) => {
        fetch(`/api/reaction.php?id=${id}&status=1`)
        .then(res => res.json())
        .then(json => {
          console.log(json);
          if(json.result === false){
            console.log("It's false...");
            likeAlert.style.display = 'initial';
          }else{
            likeBtn.classList.add('active');
          }
        });
      });

      // When dislike btn is clicked
      dislikeBtn.addEventListener('click', (event) => {
        fetch(`/api/reaction.php?id=${id}&status=2`)
        .then(res => res.json())
        .then(json => {
          console.log(json);
          if(json.result === false){
            console.log("It's false...");
            dislikeAlert.style.display = 'initial';
          }else{
            dislikeBtn.classList.add('active');
          }
        });
      });

      // When comment btn is clicked
      commentBtn.addEventListener('click', (event) => {
        fetch(`/api/reaction.php?id=${id}&status=0`)
        .then(res => res.json())
        .then(json => {
          console.log(json);
          commentAlert.style.display = 'initial';
        });
      });
    });
  }
})();
