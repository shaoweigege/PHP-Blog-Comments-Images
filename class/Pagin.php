<?php

class Pagin {

    public $totpages;

    function setup($total, $perpage, $pageno)
    {
        $this->totpages = ceil($total/$perpage);
        if ($pageno > $this->totpages)
            $pageno = $this->totpages;
        $offset = ($pageno - 1) * $perpage;
        return $offset;
    }

    function showfoot()
    {
        if ($this->totpages > 1) {
            echo '<div class="post">'."\n";
            echo 'Page: ';
            for($i = 1; $i <= $this->totpages; $i++)
                echo '<a href="index.php?p='.$i.'">'.$i.'</a> ';
            echo "\n".'</div>'."\n";
        }
    }
}

return new Pagin;
