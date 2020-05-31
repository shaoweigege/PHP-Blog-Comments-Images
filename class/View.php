<?php

class View
{

    function viewPosts($posts, $db)
    {
        foreach($posts as $post) {
            if (strlen($post->postbody) > 64) {
                $strarr = explode('xyx', wordwrap($post->postbody, 64, 'xyx'));
                $postbody = $strarr[0].' ....';
            }
            else {
                $postbody = $post->postbody;
            }
            $numCom = $db->countCom($post->id);
            $uname = $db->getUnameById($post->userid);
            $date = ucfirst(utf8_encode(strftime('%A %e %B %Y %H:%M', $post->stamptime)));
            echo '<div class="post">';
            echo '<span class="title"><a href="readpost.php?id='.$post->id.'">'.
                            $post->posttitle.'</a></span>';
            echo '<span class="info"> by '.$uname.' '.$date."</span><br>\n";
            echo '<div class="texten">';
            echo nl2br($postbody, false);
            echo  '</div>';
            echo '<a href="readpost.php?id='.$post->id.'">Comments('.$numCom.')</a>';
            echo '</div>';
            echo '<div class="thickline"></div>'."\n";
        }
    }

    function viewOnePost($post, $db)
    {
        if ($post->image) {
            $image = 'images/'.$post->image;
            $thumb = 'images/tmb_'.pathinfo($post->image, PATHINFO_FILENAME).'.png';
            $imageOutput = '<a href="'.$image.'" target="_blank"><img src="'.$thumb.'"></a>';
        } else {
            $imageOutput = '';
        }
        $uname = $db->getUnameById($post->userid);
        $date = ucfirst(utf8_encode(strftime('%A %e %B %Y %H:%M', $post->stamptime)));
        echo '<div class="post">';
        echo '<span class="title"><a href="readpost.php?id='.$post->id.'">'.
                        $post->posttitle.'</a></span>';
        echo '<span class="info"> by '.$uname.' '.$date;
        if (ULEVEL == 2)
            echo ' <a href="editpost.php?id='.$post->id.'">Edit</a>';
        echo '</span><br>';
        echo '<div class="texten">';
        echo '<div class="image">'.$imageOutput.'</div>'."\n";
        echo nl2br($post->postbody, false);
        echo '<div class="clearboth"></div>';
        echo '</div>';
        echo '</div>';
        echo '<div class="thickline"></div>'."\n";
    }

    function viewComments($comments)
    {
        foreach($comments as $com) {
            echo '<div class="post">';
            echo '<span class="title">';
            echo $com->author.':';
            echo '</span> <span class="info">';
            echo ucfirst(utf8_encode(strftime('%A %e %B %Y %H:%M', $com->stamptime)));
            if (ULEVEL == 2)
                echo ' <a href="editcomment.php?id='.$com->id.'">Edit</a>';
            echo '</span><br>';
            echo '<div class="texten">';
            echo nl2br($com->comment, false);
            echo '</div>';
            echo '</div>';
            echo '<div class="line"></div>'."\n";
        }
    }

    function addPostForm($valid)
    {
?>
        <div class="post">
        <br>
        Add Post
        <br><br>
        <form method="post" enctype="multipart/form-data">
            <?php $valid->csrf_create() ?>
            <input name="title" placeholder="Title" size="50"><br>
            <textarea name="body" placeholder="Body" cols="60" rows="10"></textarea><br>
            Image Upload <input name="image" type="file"><br><br>
            <input type="submit" name="submit">
            <input type="button" value="Cancel"
                onClick="window.location.href='index.php'">
        </form>
        </div>
<?php
    }

    function commentsForm($id, $valid)
    {
        ?>
        <div class="post"><br>
        <form method="post">
        <?php $valid->csrf_create() ?>
        <input name="author" placeholder="Your Name" size="30" required><br>
        <textarea name="comment" placeholder="Your Comment" 
                    cols="50" rows="8" required></textarea><br>
        <img src="include/captchaimg.php"><br>
        <?php $valid->captcha_input() ?><br>
        <input name="postid" type="hidden" value="<?php echo $id ?>">
        <input name="submit" type="submit">
        <input type="button" value="Cancel"
            onClick="window.location.href='index.php'">
        </form>
        </div>
        <?php
    }        

    function editPostForm($post) {
        ?>
        <div class="post">
        <br>
        Edit Post
        <br><br>
        <form method="post">
            <input name="title" size="58" 
                placeholder="Title" value="<?php echo $post->posttitle ?>" required>
            <br>
            <textarea name="body" cols="60" rows="8" 
                placeholder="Body" required><?php echo $post->postbody ?></textarea>
            <br>
            <input name="postid" type="hidden" value="<?php echo $post->id ?>">
            <input name="userid" type="hidden" value="<?php echo $post->userid ?>">
            <input name="submit" type="submit" value="Edit">
            <input name="submit" type="submit" value="Delete"
                onclick="return confirm('Delete. Are you sure?')">
            <input type="button" value="Cancel"
                onClick="window.location.href=
                'readpost.php?id=<?php echo $post->id ?>'">
        </form>
        <br>
        </div>
        <?php
    }

    function editCommentForm($com) {
        ?>
        <div class="post">
        <br>
        Edit Comment
        <br><br>
        <form method="post">
            <input name="author" size="58" 
                value="<?php echo $com->author ?>" readonly>
            <br>
            <textarea name="comment" cols="60" rows="8"
                    required><?php echo $com->comment ?></textarea>
            <br>
            <input name="comid" type="hidden" value="<?php echo $com->id ?>">
            <input name="postid" type="hidden" value="<?php echo $com->postid ?>">
            <input name="submit" type="submit" value="Edit">
            <input name="submit" type="submit" value="Delete"
                onclick="return confirm('Delete. Are you sure?')">
            <input type="button" value="Cancel"
                onClick="window.location.href=
                'readpost.php?id=<?php echo $com->postid ?>'">
        </form>
        <br>
        </div>
        <?php
    }

    function loginForm($valid, $error)
    {
?>
        <div class="post">
        <?php echo $error ?>
        <br>
        Login
        <br><br>
        <form method="post">
        <?php $valid->csrf_create() ?>
        <input name="uname" placeholder="Username"><br>
        <input name="upass" type="password" placeholder="Password"><br>
        <input type="submit" name="submit">
        <input type="button" value="Cancel"
            onClick="window.location.href='index.php'">
        </form>
        </div>
<?php
    }

    function signUpForm($valid)
    {
?>
        <br>
        Sign Up
        <br><br>
        <form method="post">
        <?php $valid->csrf_create() ?>
        <input name="uname" placeholder="User Name"><br>
        <input name="upass" type="password" placeholder="User Password"><br>
        <input name="upass2" type="password" placeholder="Password Again"><br>
        <img src="include/captchaimg.php"><br>
        <?php $valid->captcha_input() ?><br>
        <input name="submit" type="submit">
        <input type="button" value="Cancel"
            onClick="window.location.href='index.php'">
        </form>
<?php
    }

    function userLevel($users)
    {
        echo '<div class="post">';
        echo '<table>';
        echo '<tr><th>ID</th><th>Name</th><th>Level</th><th></th></tr>';
        foreach($users as $row) {
            echo '<tr>';
            echo '<td>'.$row->id.'</td>';
            echo '<td>'.$row->uname.'</td>';
            echo '<td>';
            echo '<form method="post">';
            echo '<input name="ulevel" type="number" min="0" max="2"
                value="'.$row->ulevel.'">';
            echo '</td><td>';
            echo '<input name="id" type="hidden" value="'.$row->id.'">';
            echo '<input name="submit" type="submit"> ';
            echo '<input type="button" value="Cancel"
                    onClick="window.location.href=\'index.php\'">';
            echo '</form>';
            echo '</td>';
            echo '</tr>'."\n";
        }
        echo '</table>';
        echo '</div>';
    }

    function listUsers($users)
    {
        echo '<div class="post">';
        echo '<table>';
        echo '<tr><th>ID</th><th>Name</th><th>Level</th><th>Posts</th></tr>';
        foreach($users as $row) {
            echo '<tr>';
            echo '<td>'.$row->id.'</td>';
            echo '<td>'.$row->uname.'</td>';
            echo '<td align="right">'.$row->ulevel.'</td>';
            echo '<td align="right">'.$row->uposts.'</td>';            
            echo '</tr>'."\n";
        }
        echo '</table>';
        echo '</div>';
    }            

    function listViews($views)
    {
        echo '<div class="post">';
        echo '<h4>Popular Articles</h4>';
        echo '<table>';
        echo '<tr><th align="left">Title</th><th>Views</th></tr>';
        foreach($views as $post) {
            echo '<tr>';
            echo '<td><a href="readpost.php?id='.
                    $post->id.'">'.$post->posttitle.'</a></td>';
            echo '<td align="right">'.$post->numviews.'</td>';
            echo '</tr>';
        }
        echo '</table><br>';
        echo '</div>';
    } 
}

return new View;
