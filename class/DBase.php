<?php

class DBase extends PDO
{
    function __construct()
    {
        require 'data/db_config.php';
        parent::__construct(DSN, USER, PASS);
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    }

    function insertPost($title, $body)
    {
        $time = time();
        $sql = "INSERT INTO posts (userid, posttitle, postbody, stamptime)
                VALUES  (".UID.", ?, ?, $time)";
        $stmt = $this->prepare($sql);
        $stmt->bindParam(1, $title, PDO::PARAM_STR);
        $stmt->bindParam(2, $body,  PDO::PARAM_STR);
        $stmt->execute();
        $sql = "UPDATE users SET uposts = uposts + 1 WHERE id=".UID."";
        $this->exec($sql);
        return $this->lastInsertId();
    }

    function updatePost($postid, $title, $body)
    {
        $sql = "UPDATE posts SET posttitle=?, postbody=?
                            WHERE id=$postid";
        $stmt = $this->prepare($sql);
        $stmt->execute([$title, $body]);
    }

    function deletePost($postid)
    {
        $sql = "DELETE FROM posts WHERE id=$postid";
        $this->exec($sql);
    }

    function deletePostComments($postid)
    {
        $sql = "DELETE FROM comments WHERE postid=$postid";
        $this->exec($sql);
    }

    function storeImage($pid, $image)
    {
        $sql = "UPDATE posts SET image='$image' WHERE id=$pid";
        $this->exec($sql);
    }

    function insertComment($author, $comment, $postid)
    {
        $time = time();
        $sql = "INSERT INTO comments (author, comment, postid, stamptime)
                VALUES  (?, ?, $postid, $time)";
        $stmt = $this->prepare($sql);
        $stmt->bindParam(1, $author,  PDO::PARAM_STR);
        $stmt->bindParam(2, $comment, PDO::PARAM_STR);
        $stmt->execute();
    }

    function countPosts()
    {
        $sql = "SELECT count(*) FROM posts";
        return $this->query($sql)->fetchColumn();
    }

    function loadPosts($offset, $perpage)
    {
        $sql = "SELECT * FROM posts ORDER BY id DESC LIMIT $offset, $perpage";
        return $this->query($sql)->fetchAll();
    }

    function loadPost($id)
    {
        $sql = "SELECT * FROM posts WHERE id=$id";
        return $this->query($sql)->fetch();
    }

    function loadComments($id)
    {
        $sql = "SELECT * FROM comments WHERE postid=$id";
        return $this->query($sql)->fetchAll();
    }

    function loadUsers()
    {
        $sql = "SELECT * FROM users";
        return $this->query($sql)->fetchAll();
    }

    function getComment($id)
    {
        $sql = "SELECT * FROM comments WHERE id=$id";
        return $this->query($sql)->fetch();
    }

    function updateComment($id, $comment)
    {
        $sql = "UPDATE comments SET comment=? WHERE id=$id";
        $stmt = $this->prepare($sql);
        $stmt->execute([$comment]);
    }

    function deleteComment($id)
    {
        $sql = "DELETE FROM comments WHERE id=$id";
        $this->exec($sql);
    }

    function insertUser($user, $pass)
    {
        $sql = "SELECT count(*) FROM users";
        $num = $this->query($sql)->fetchColumn();
        $ulevel = $num ? 1 : 2;
        $hash = password_hash($pass, PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (uname, upass, ulevel) 
                VALUES (?, '$hash', $ulevel)";
        $stmt = $this->prepare($sql);
        $stmt->bindParam(1, $user, PDO::PARAM_STR);
        $stmt->execute();
    }

    function updateLevel($id, $ulevel)
    {
        $sql = "UPDATE users SET ulevel=$ulevel WHERE id=$id";
        $this->exec($sql);
    }

    function increaseUposts($id)
    {
        $sql = "UPDATE users SET uposts = uposts + 1 WHERE id=$id";
        $this->exec($sql);
    }

    function decreaseUposts($id)
    {
        $sql = "UPDATE users SET uposts = uposts - 1 WHERE id=$id";
        $this->exec($sql);
    }

    function  countCom($id)
    {
        $sql = "SELECT count(*) FROM comments WHERE postid=$id";
        return $this->query($sql)->fetchColumn();
    }

    function increaseView($id)
    {
        $sql = "UPDATE posts SET numviews = numviews + 1 WHERE id=$id";
        $this->exec($sql);
    }
        
    function getUnameById($id)
    {
        $sql = "SELECT uname FROM users WHERE id=$id";
        return $this->query($sql)->fetchColumn();
    }

    function getUname($uname)
    {
        $sql = "SELECT uname FROM users WHERE uname='$uname'";
        return $this->query($sql)->fetchColumn();
    }

    function getViews()
    {
        $sql = "SELECT id, posttitle, numviews FROM posts 
        ORDER BY numviews DESC, id DESC LIMIT 10";
        return $this->query($sql)->fetchAll();
    }

    function doLogin()
    {
        $rpost =  filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        extract($rpost);
        $sql = "SELECT * FROM users WHERE uname = '$uname'";
        $row = $this->query($sql)->fetch();
        if ($row && password_verify($upass, $row->upass)) {
            $data = json_encode([$row->id, $row->uname, $row->ulevel]);
            setcookie('userdata2', $data, time() + 14*24*3600);
        }
    }
    function doSignUp()
    {
        $rpost =  filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        extract($rpost);
        if ($upass == $upass2) {
            $name = $this->getUname($uname);
            if (!$name) {
                $this->insertUser($uname, $upass);
                echo 'Success!</div>';
                require 'include/footer.php';
                exit();
            } else {
                echo 'Username already taken';
            }
        } else {
            echo 'Passwords don\'t match';
        }
    }

    function imageUpload($pid)
    {
        $temp = $_FILES['image']['tmp_name'];

        $typ = exif_imagetype($temp);
        if (!$typ)
            return;
        if     ($typ ==  1) $im = imagecreatefromgif($temp);
        elseif ($typ ==  2) $im = imagecreatefromjpeg($temp);
        elseif ($typ ==  3) $im = imagecreatefrompng($temp);
        elseif ($typ ==  6) $im = imagecreatefrombmp($temp);
        elseif ($typ == 18) $im = imagecreatefromwebp($temp);
        else {
            echo '<div class="post"><br>';    
            echo 'Image type not supported: '.mime_content_type($temp);
            echo '<br><br></div>';
            require 'include/footer.php';
        }

        $filename = $pid.'_'.bin2hex(random_bytes(4));
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $image = $filename.'.'.$ext;
        move_uploaded_file($temp, 'images/'.$image);

        $sx = imagesx($im);
        $sy = imagesy($im);
        $ts = 200;
        $k = min($ts/$sx, $ts/$sy);
        $thumb = imagecreatetruecolor($k*$sx, $k*$sy);
        imagecopyresampled($thumb, $im, 0, 0, 0, 0, $k*$sx, $k*$sy, $sx, $sy);

        imagepng($thumb, 'images/tmb_'.$filename.'.png');
        imagedestroy($im);

        $this->storeImage($pid, $image);
    }
}

return new DBase;
        