'use strict';

(function () {

  // Scripts for the profile-page
  if (document.querySelector('.user-profile')) {
    const clickableText = document.querySelector('.user-profile .img-change');
    const innerProfileImgContainer = document.querySelector('.user-profile .profile-img-container .inner-profile-img-container');
    const profileImgForm = document.querySelector('.user-profile .profile-img-form');
    let profileImgInput = document.querySelector('.user-profile #image');
    const profileImg = document.querySelector('.profile-img-container img');


    clickableText.addEventListener('click', () => openProfileImgForm());
    innerProfileImgContainer.addEventListener('click', () => openProfileImgForm());

    function openProfileImgForm() {
      profileImgInput.click();
    };

    profileImgForm.addEventListener('change', () => {
      profileImgForm.submit();
    });
  }

  // Scripts for the avatar submit form
  if (document.querySelector('.create-post-form')) {
    const img = document.querySelector('#img-preview-input');
    const imgInput = document.querySelector('form.create-post-form input#image');
    const inputBtn = document.querySelector('#img-preview-input + div.btn');

    img.addEventListener('click', () => openProfileImgForm());
    inputBtn.addEventListener('click', () => openProfileImgForm());

    function openProfileImgForm() {
      imgInput.click();
    };

    imgInput.addEventListener('change', () => {
      if (imgInput.files && imgInput.files[0]) {
        img.setAttribute('src',
          window.URL.createObjectURL(imgInput.files[0])
        );
      }
    });
  }

  // Scripts for posts
  if (document.getElementById('post-container')) {
    const post_container = document.getElementById('post-container');
    const posts = post_container.querySelectorAll('section');

    posts.forEach((post) => {
      const id = post.querySelector('.post').dataset.id;
      const likeBtn = post.querySelector('.like');
      const dislikeBtn = post.querySelector('.dislike');
      const commentBtn = post.querySelector('.comment');

      const likeAlert = post.querySelector('.like-alert');
      const dislikeAlert = post.querySelector('.dislike-alert');
      const commentAlert = post.querySelector('.comment-alert');

      // process reactions such as likes & dislikes
      const processReaction = (likeButton, dislikeButton, alert, response) => {
        console.log(response);

        if (response.result === false) {
          alert.style.display = 'initial';
          return false;
        }

        likeButton.querySelector('span').innerText = response.likes;
        dislikeButton.querySelector('span').innerText = response.dislikes;
        return true;
      }

      // When like btn is clicked
      likeBtn.addEventListener('click', (event) => {
        console.log(`/api/reaction.php?id=${id}&status=1`);
        fetch(`/api/reaction.php?id=${id}&status=1`)
          .then(res => res.json())
          .then(json => {
            console.log(processReaction(likeBtn, dislikeBtn, likeAlert, json));

          });
      });

      // When dislike btn is clicked
      dislikeBtn.addEventListener('click', (event) => {
        console.log(`/api/reaction.php?id=${id}&status=-1`);

        fetch(`/api/reaction.php?id=${id}&status=-1`)
          .then(res => res.json())
          .then(json => {
            console.log(processReaction(likeBtn, dislikeBtn, dislikeAlert, json));
          });
      });

      // When comment btn is clicked
      commentBtn.addEventListener('click', (event) => {
        console.log(`/api/reaction.php?id=${id}&status=1`);
        fetch(`/api/reaction.php?id=${id}&status=1`)
          .then(res => res.json())
          .then(json => {
            console.log(json);
            commentAlert.style.display = 'initial';
          });
      });

      // Delete btn modal
      if (post.querySelector('button.delete')) {
        const deleteBtn = post.querySelector('button.delete');
        const modal = post.querySelector('.custom_modal');

        deleteBtn.addEventListener('click', () => {

          modal.style.display = 'initial';
          post.querySelectorAll('.custom_modal .close-btn').forEach((btn) => {
            btn.addEventListener('click', () => {
              modal.style.display = 'none';
            });
          });

        });
      }

    });

  }
})();
