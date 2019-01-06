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
    const processReaction = (baseBtn, baseAlert, oppositeBtn, response) => {
      if (response.result === false) {
        baseAlert.style.display = 'initial';
        return false;
      }

      if (response.change === 'add') {
        baseBtn.querySelector('span').innerHTML++;
        return true;

      } else if (response.change === 'remove') {
        baseBtn.querySelector('span').innerHTML--;
        return true;

      } else if (response.change === 'switch') {
        baseBtn.querySelector('span').innerHTML++;
        oppositeBtn.querySelector('span').innerHTML--;
        return true;
      }
    }

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


      // When like btn is clicked
      likeBtn.addEventListener('click', (event) => {
        fetch(`/api/reaction.php?id=${id}&status=1`)
          .then(res => res.json())
          .then(json => {
            if (!processReaction(likeBtn, likeAlert, dislikeBtn, json));

          });
      });

      // When dislike btn is clicked
      dislikeBtn.addEventListener('click', (event) => {
        fetch(`/api/reaction.php?id=${id}&status=2`)
          .then(res => res.json())
          .then(json => {
            processReaction(dislikeBtn, dislikeAlert, likeBtn, json);
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
