<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>😂 Funny Videos</title>
    <style>
        /* Same CSS as stories.php for consistency */
        body { font-family: sans-serif; background: linear-gradient(45deg, #30cfd0, #330867); min-height: 100vh; color: white; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; text-align: center; }
        .video-card { background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); padding: 30px; border-radius: 20px; margin: 20px 0; border: 1px solid rgba(255,255,255,0.3); }
        .btn { padding: 10px 20px; border: none; border-radius: 20px; cursor: pointer; color: white; font-weight: bold; margin: 5px; }
        .btn-next { background: #f093fb; }

        /* Comment Styles */
        .comment-box { margin-top: 30px; text-align: left; }
        .c-input { width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 10px; border: none; background: rgba(255,255,255,0.3); color: white; }
        .c-list { max-height: 200px; overflow-y: auto; margin-top: 15px; }
        .c-item { background: rgba(0,0,0,0.2); padding: 10px; margin-bottom: 8px; border-radius: 10px; }
        .c-name { font-weight: bold; color: #f8b500; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎬 Funny Videos</h1>
        <div class="video-card">
            <h2 id="v-title">Cat Fails</h2>
            <div style="background:black; height:300px; border-radius:10px; display:flex; align-items:center; justify-content:center;">
                Video Player Here
            </div>
            <button class="btn btn-next" onclick="nextVideo()">Next Video</button>
        </div>

        <!-- Comment Section -->
        <div class="video-card comment-box">
            <h3>💬 Comments</h3>
            <div id="comment-list" class="c-list">Loading...</div>
            <input type="text" id="c-name" class="c-input" placeholder="Your Name">
            <textarea id="c-msg" class="c-input" placeholder="Write a comment..."></textarea>
            <button class="btn btn-next" onclick="postComment('videos')">Post Comment</button>
        </div>
    </div>

    <script>
        // Demo Videos
        const videos = [
            {t: "Cat Fails"},
            {t: "Baby Laughing"}
        ];
        let idx = 0;

        function nextVideo() {
            idx = (idx + 1) % videos.length;
            document.getElementById('v-title').innerText = videos[idx].t;
        }

        // --- SAME COMMENT LOGIC AS STORIES ---
        async function loadComments(page) {
            const res = await fetch(`comments.php?page=${page}`);
            const data = await res.json();
            const list = document.getElementById('comment-list');
            
            if(data.length === 0) {
                list.innerHTML = "<p>No comments yet.</p>";
                return;
            }

            let html = '';
            data.forEach(item => {
                html += `<div class="c-item"><span class="c-name">${item.user_name}</span>: ${item.message} <br><small>${item.created_at}</small></div>`;
            });
            list.innerHTML = html;
        }

        async function postComment(page) {
            const name = document.getElementById('c-name').value;
            const msg = document.getElementById('c-msg').value;

            if(name && msg) {
                await fetch('comments.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({ page: page, name: name, msg: msg })
                });
                document.getElementById('c-msg').value = '';
                loadComments(page);
            } else {
                alert("Please fill all fields!");
            }
        }

        // Load comments for 'videos' page
        loadComments('videos');
    </script>
</body>
</html>