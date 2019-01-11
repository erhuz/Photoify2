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
      let id = post.querySelector('.post').dataset.id;
      const likeBtn = post.querySelector('.like');
      const dislikeBtn = post.querySelector('.dislike');
      const commentBtn = post.querySelector('.comment-btn');

      const showCommentsBtn = post.querySelector('.show-comments-btn');
      const commentFormContainer = post.querySelector('.comment-form-container');
      const commentContainer = post.querySelector('.comment-container');
      const commentLoader = post.querySelector('.comment-loader');
      const commentForm = post.querySelector('form.comment-form');
      const commentInput = post.querySelector('form.comment-form input[type="text"]');
      const commentSubmit = post.querySelector('form.comment-form .button [type="submit"]');

      const likeAlert = post.querySelector('.like-alert');
      const dislikeAlert = post.querySelector('.dislike-alert');
      const commentAlert = post.querySelector('.comment-alert');

      // process reactions such as likes & dislikes
      const processReaction = (likeButton, dislikeButton, alert, response) => {

        if (response.result === false) {
          alert.style.display = 'initial';
          return false;
        }

        likeButton.querySelector('span').innerText = response.likes;
        dislikeButton.querySelector('span').innerText = response.dislikes;
        return true;
      }

      const readComments = (id) => {
        commentLoader.style.display = 'initial';
        fetch(`/api/comment.php?id=${id}&action=read`)
          .then(res => res.json())
          .then(comments => {
            if(comments === false){
              commentAlert.style.display = 'initial';
            }else{
              let commentsOutput = '';
              comments.forEach((commentData) => {
                const comment = `
                <div class="row comment"> <!-- Comment -->
                  <div class="col">
                    <hr>

                    <div class="row comment-user-info">
                      <div class="comment-user-avatar">
                        <img class="profile-picture rounded-circle" src="${commentData.avatar}" alt="${commentData.name}">
                      </div>

                      <h6 class="comment-user-name-container m-0 ml-2">
                        <a class="comment-user-name" href=/profile.php?id=USER_ID">
                          ${commentData.name}
                        </a>
                      </h6>
                    </div>

                    <div class="row">
                      <div class="col comment-content p-0">
                        <div class="bg-light p-1 pl-2">
                          ${commentData.content}
                        </div>
                      </div>
                    </div>

                  </div>
                </div> <!-- /Comment -->
                `;

                commentsOutput += comment;
              });

              commentContainer.innerHTML = commentsOutput;

              commentContainer.style.display = 'initial';
              commentLoader.style.display = 'none';
            }


          })
          .catch((error) => {
            commentLoader.style.display = 'none';
          });
      }

      const storeComment = (id, content) => {
        const commentInputContent = content;
        fetch(`/api/comment.php?id=${id}&action=store&content=${commentInputContent}`)
        .then(res => res.json())
        .then(json => {
          showComments(id);
        });
      }

      // When like btn is clicked
      likeBtn.addEventListener('click', (event) => {

        fetch(`/api/reaction.php?id=${id}&status=1`)
          .then(res => res.json())
          .then(json => {
            processReaction(likeBtn, dislikeBtn, likeAlert, json);

          });
      });

      // When dislike btn is clicked
      dislikeBtn.addEventListener('click', (event) => {

        fetch(`/api/reaction.php?id=${id}&status=-1`)
          .then(res => res.json())
          .then(json => {
            processReaction(likeBtn, dislikeBtn, dislikeAlert, json);
          });
      });

      /** Comment Psuedo
       *  If comment (reaction button) is clicked
       *    remove show-comments-btn, show comment form (w/ first input
       *     clicked), load comments on post
       *
       *  If show-comments-btn is clicked
       *    remove show-comments-btn, show comment form, load comments on posts
       */

      //! COMMENT DISPLAY BUTTONS
      // When comment btn is clicked
      commentBtn.addEventListener('click', (event) => {

        showCommentsBtn.style.display = 'none';
        commentFormContainer.style.display = 'initial';
        commentInput.focus();
        commentInput.select();
        readComments(id);
      });

      showCommentsBtn.addEventListener('click', (event) => {

        showCommentsBtn.style.display = 'none';
        commentFormContainer.style.display = 'initial';
        commentContainer.style.display = 'initial';
        readComments(id);
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
